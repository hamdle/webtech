<?php

/*
 * Class WorkoutController
 *
 * Handle requests for user workout information.
 *
 * @author Eric Jawaid Marty
 * @since 12/24/2023 12:00 PM
 */

namespace Api\Controller;

use Api\Core\Database\Database;
use Api\Core\Database\Query;
use Api\Core\Http\Code;
use Api\Core\Http\Response;
use Api\Model\Exercise;
use Api\Model\ExerciseType;
use Api\Model\Rep;
use Api\Model\Workout;
use Api\Rpc;

class WorkoutController
{
    // POST :: api/Workout/save
    public function save()
    {
        $request = Rpc::getRequest();
        $workout = new Workout($request);
        $workout->user_id = Rpc::getUser()->fields["id"];
        $workout->save();

        foreach ($request["exercises"] ?? [] as $exerciseEntry)
        {
            $exercise = new Exercise($exerciseEntry);
            $exercise->workout_id = $workout->id;
            $exercise->user_id = Rpc::getUser()->fields["id"];
            // Saving the exercise will unset `reps` since it"s not a field in
            // the `exercises` table. So we need to get the reps from this
            // exercise before saving it.
            $reps = $exerciseEntry["reps"] ?? [];
            $exercise->save();

            // TODO: add bulk save to Database and use it here
            foreach ($reps as $repEntry)
            {
                $rep = new Rep($repEntry);
                $rep->exercise_id = $exercise->id;
                $rep->save();
            }
        }

        return Response::sendOk();
    }

    // POST :: api/workout/exerciseTypes
    public function exerciseTypes()
    {
        $exerciseTypes = new ExerciseType();
        $response = array_merge(
            ["ok" => "true"],
            ["exercise_types" => $exerciseTypes->all()]
        );
        return Response::send(Code::OK_200, $response);
    }

    // POST :: api/workout/all
    public function all($args)
    {
        $exerciseTypes = Database::run("
            select *
            from exercise_types
        ");

        $exerciseTypesByKey = [];

        foreach ($exerciseTypes as $exerciseType)
        {
            $exerciseTypesByKey[$exerciseType["id"]] = $exerciseType;
        }

        $pageNumber = $args["page"] ?? 1;
        $limit = Database::config("pagination_default", Rpc::getUser()->fields["id"]);
        $workouts = Database::execute('user-workouts.sql', [
            'user_id' => Rpc::getUser()->fields["id"],
            'limit' => $limit,
            "offset" => $limit * ($pageNumber - 1)
        ]);

        if (!$workouts)
        {
            $response = array_merge(
                ["ok" => "true"],
                ["warning" => "no results"],
                ["workouts" => null]
            );
            return Response::send(Code::OK_200, $response);
        }

        // TODO: change to Database::insert(sql, ids) so Database class use prepare
        $exercises = Database::run("
            select *
            from exercises
            where exercises.workout_id in
            (".implode(", ", array_column($workouts, "id")).")
        ");
        // TODO: change to Database::insert(sql, ids) so Database class use prepare
        $reps = Database::run("
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
            ["workouts" => $data],
        );
        return Response::send(Code::OK_200, $response);
    }

    // POST :: api/workout/suggestedReps
    public function suggestedReps($args) {
        $results = Database::execute('last-exercise.sql', [
            'user_id' => Rpc::getUser()->fields["id"],
            'exercise_type_id' => intval($args['exerciseTypeId'])
        ]);

        $workoutId = $results[0]['id'];

        $reps = Database::execute('suggested-reps.sql', [
            'user_id' => Rpc::getUser()->fields["id"],
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
