<?php

use api\Rpc;
use api\Core\Http\Request;

require_once dirname(__DIR__, 2) . "/autoload.php";

// TODO: endpoints to replace
//Api::get("auth",        "Authentication",   "verifySession");
//Api::get("exercises",   "Workouts",         "exerciseTypes");
//Api::get("suggest/reps/{exercise_type_id}", "Workouts", "suggestReps");
//Api::post("workouts/new",   "Workouts",         "save");

$request = Request::post();
Rpc::handle($request);