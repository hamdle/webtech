<?php

/*
 * Class WorkoutController
 *
 * Handle requests for user workout information.
 *
 * @author Eric Jawaid Marty
 * @since 12/24/2023 12:00 PM
 */

namespace App\Controller;

use App\Core\Database\Database;
use App\Core\Database\Query;
use App\Core\Http\Code;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Model\Exercise;
use App\Model\ExerciseType;
use App\Model\Rep;
use App\Model\Workout;
use App\Rpc;

class WorkoutController extends BaseController
{
    public function timer(): Response
    {
        $this->renderHtmlTemplate('WorkoutTimer');
        return $this->response;
    }

    public function view(): Response
    {
        $this->renderHtmlTemplate('WorkoutView');
        return $this->response;
    }

    public function go(): Response
    {
        $this->renderHtmlTemplate('WorkoutGo');
        return $this->response;
    }

    // POST :: api/Workout/save
    public function save($args)
    {
        $this->response->setJson();

        $workout = new Workout($args);
        $workout->user_id = \App\Core\Context::get('user')->fields["id"];
        $workout->save();

        foreach ($args["exercises"] ?? [] as $exerciseEntry)
        {
            $exercise = new Exercise($exerciseEntry);
            $exercise->workout_id = $workout->id;
            $exercise->user_id = \App\Core\Context::get('user')->fields["id"];
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

        $this->response->setContent([
            "error" => "false",
            "message" => "Workout saved successfully.",
        ]);
        return $this->response;
    }

    public function saveTime($args)
    {
        $this->response->setJson();

        $start = $args["start"] ?? null;
        $end = $args["end"] ?? null;
        $notes = $args["notes"] ?? null;
        $feel = $args["feel"] ?? null;
        if (!$start || !$end || !$feel) {
            $this->response->setContent([
                "error" => "true",
                "message" => "Invalid data.",
            ]);
            return $this->response;
        }

        $user = $user = \App\Core\Context::get('user');

        $workout = new Workout($args);
        $workout->user_id = $user->fields["id"];
        $workout->save();

        $this->response->setContent([
            "error" => "false",
            "message" => "Workout saved successfully.",
        ]);
        return $this->response;
    }

    public function exerciseTypes()
    {
        $this->response->setJson();
        $exerciseTypes = new ExerciseType();
        $this->response->setContent([
            "error" => "false",
            "exercise_types" => $exerciseTypes->all(),
        ]);
        return $this->response;
    }

    public function all($args)
    {
        $this->response->setJson();

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
        $limit = Database::config("pagination_default", \App\Core\Context::get('user')->fields["id"]);
        $workouts = Database::execute('user-workouts.sql', [
            'user_id' => \App\Core\Context::get('user')->fields["id"],
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
        $reps = [];
        if ($exercises)
        {
            $reps = Database::run("
                select *
                from reps
                where reps.exercise_id in
                (".implode(", ", array_column($exercises, "id")).")
            ");
        }


        $data = [];
        $sort = count($workouts);
        foreach ($workouts as $workout)
        {
            $data[$workout["id"]] = $workout;
            $data[$workout["id"]]['sort'] = $sort;
            $sort--;
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

        $this->response->setContent([
            "error" => "false",
            "workouts" => $data,
        ]);
        return $this->response;
    }

    public function suggestedReps($args) {
        $this->response->setJson();

        $results = Database::execute('last-exercise.sql', [
            'user_id' => \App\Core\Context::get('user')->fields["id"],
            'exercise_type_id' => intval($args['exerciseTypeId'])
        ]);

        $reps = [];

        if ($results !== null && array_key_exists(0, $results))
        {
            $workoutId = $results[0]['id'];
            $reps = Database::execute('suggested-reps.sql', [
                'user_id' => \App\Core\Context::get('user')->fields["id"],
                'exercise_type_id' => intval($args['exerciseTypeId']),
                'workout_id' => $workoutId
            ]);
        }

        $data = [];
        foreach ($reps as $rep) {
            $data[] = $rep[array_key_first($rep)];
        }

        $this->response->setContent([
            "error" => "false",
            "suggestedReps" => $data,
        ]);
        return $this->response;
    }
}
