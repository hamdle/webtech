<?php

/*
 * Controllers/Workouts.php: handle workout requests
 *
 * This controller should handle all request pertaining to reading or writing
 * workout details.
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace api\Controller;

use api\Core\Database\Database;
use api\Core\Database\Query;
use api\Core\Http\Code;
use api\Core\Http\Request;
use api\Core\Http\Response;
use api\Model\Exercise;
use api\Model\ExerciseType;
use api\Model\Rep;
use api\Model\Session;
use api\Model\Workout;
use api\Rpc;

class WorkoutController
{
    // The default number of past workouts to query for a user.
    const ALL_WORKOUTS_LIMIT = 20;

    // return = \Http\Response
    public function save()
    {
        $session = new Session();

        if (!$session->loadUser())
            return Response::send(Code::UNAUTHORIZED_401);

        $workout = new Workout(Request::complexData());
        $workout->user_id = $session->user->id;

        if (!$workout->validate())
            return Response::send(Code::UNPROCESSABLE_ENTITY_422, $workout->getMessages());

        if (!$workout->save())
            return Response::send(Code::INTERNAL_SERVER_ERROR_500);

        foreach (Request::complexData()["exercises"] ?? [] as $exerciseEntry)
        {
            $exercise = new Exercise($exerciseEntry);
            $exercise->workout_id = $workout->id;
            $exercise->user_id = $session->user->id;
            // Saving the exercise will unset `reps` since it"s not a field in
            // the `exercises` table. So we need to get the reps from this
            // exercise before saving it.
            $reps = $exerciseEntry["reps"] ?? [];

            if (!$exercise->validate())
                return Response::send(Code::UNPROCESSABLE_ENTITY_422, $exercise->getMessages());

            if (!$exercise->save())
                return Response::send(Code::INTERNAL_SERVER_ERROR_500);

            foreach ($reps as $repEntry)
            {
                $rep = new Rep($repEntry);
                $rep->exercise_id = $exercise->id;

                if (!$rep->validate())
                    return Response::send(Code::UNPROCESSABLE_ENTITY_422, $rep->getMessages());

                if (!$rep->save())
                    return Response::send(Code::INTERNAL_SERVER_ERROR_500);
            }
        }

        return Response::send(Code::CREATED_201);
    }

    // return = \Http\Response
    public function exerciseTypes()
    {
        $exerciseTypes = new ExerciseType();
        $response = array_merge(
            ["ok" => "true"],
            ["exercise_types" => $exerciseTypes->all()]
        );
        return Response::send(Code::OK_200, $response);
    }

    // Return list of workouts from most recent to ALL_WORKOUTS_LIMIT.
    // return = \Http\Response
    public function all($limit)
    {
        $limit = $limit ? $limit : self::ALL_WORKOUTS_LIMIT;

        $exerciseTypes = Query::run("
            select *
            from exercise_types
        ");

        $exerciseTypesByKey = [];

        foreach ($exerciseTypes as $exerciseType)
        {
            $exerciseTypesByKey[$exerciseType["id"]] = $exerciseType;
        }

        $workouts = Database::execute('user-workouts.sql', [
            'user_id' => Rpc::getUser()->id,
            'limit' => $limit
        ]);
        $exercises = Query::run("
            select *
            from exercises
            where exercises.workout_id in
            (".implode(", ", array_column($workouts, "id")).")
        ");
        $reps = Query::run("
            select *
            from reps
            where reps.exercise_id in
            (".implode(", ", array_column($exercises, "id")).")
        ");

        $data = [];

        foreach ($workouts as $workout)
        {
            $data[$workout["id"]] = $workout;
        }

        foreach ($exercises as $exercise)
        {
            $data[$exercise["workout_id"]]["exercises"][$exercise["id"]] = $exercise;
            $data[$exercise["workout_id"]]["exercises"][$exercise["id"]]["exercise_type"] = $exerciseTypesByKey[$exercise["exercise_type_id"]];

            foreach ($reps as $rep)
            {
                if ($rep["exercise_id"] == $exercise["id"])
                {
                    $data[$exercise["workout_id"]]["exercises"][$exercise["id"]]["reps"][$rep["id"]] = $rep;
                }
            }
        }

        $response = array_merge(
            ["ok" => "true"],
            ['workouts' => $data]
        );
        return Response::send(Code::OK_200, $response);
    }

    public function suggestReps($args) {
        $session = new Session();

        if (!$session->loadUser())
            return Response::send(Code::UNAUTHORIZED_401);

        $results = Database::execute('last-exercise.sql', [
            'user_id' => $session->user->id,
            'exercise_type_id' => intval($args['exercise_type_id'])
        ]);

        $workoutId = $results[0]['id'];

        $reps = Database::execute('suggested-reps.sql', [
            'user_id' => $session->user->id,
            'exercise_type_id' => intval($args['exercise_type_id']),
            'workout_id' => $workoutId
        ]);

        $data = [];
        foreach ($reps as $rep) {
            $data[] = $rep[array_key_first($rep)];
        }
        return Response::send(Code::OK_200, $data);
    }
}
