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
use api\Model\Workout;
use api\Rpc;

class WorkoutController
{
    // The default number of past workouts to query for a user.
    const ALL_WORKOUTS_LIMIT = 20;

    public function save()
    {
        $request = Rpc::getRequest();
        $workout = new Workout($request);
        $workout->user_id = Rpc::getUser()->id;
        $workout->validateFormFields();
        $workout->save();

        foreach ($request["exercises"] ?? [] as $exerciseEntry)
        {
            $exercise = new Exercise($exerciseEntry);
            $exercise->workout_id = $workout->id;
            $exercise->user_id = Rpc::getUser()->id;
            // Saving the exercise will unset `reps` since it"s not a field in
            // the `exercises` table. So we need to get the reps from this
            // exercise before saving it.
            $reps = $exerciseEntry["reps"] ?? [];

            $exercise->validateFormFields();
            $exercise->save();

            foreach ($reps as $repEntry)
            {
                $rep = new Rep($repEntry);
                $rep->exercise_id = $exercise->id;

                $rep->validateFormFields();
                $rep->save();
            }
        }

        return Response::sendOk();
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
    public function all($args)
    {
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
            'limit' => self::ALL_WORKOUTS_LIMIT
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
            ["workouts" => $data]
        );
        return Response::send(Code::OK_200, $response);
    }

    public function suggestedReps($args) {
        $results = Database::execute('last-exercise.sql', [
            'user_id' => Rpc::getUser()->id,
            'exercise_type_id' => intval($args['exerciseTypeId'])
        ]);

        $workoutId = $results[0]['id'];

        $reps = Database::execute('suggested-reps.sql', [
            'user_id' => Rpc::getUser()->id,
            'exercise_type_id' => intval($args['exerciseTypeId']),
            'workout_id' => $workoutId
        ]);

        $data = [];
        foreach ($reps as $rep) {
            $data[] = $rep[array_key_first($rep)];
        }
        $response = array_merge(
            ["ok" => "true"],
            ['suggestedReps' => $data]
        );
        return Response::send(Code::OK_200, $response);
    }
}
