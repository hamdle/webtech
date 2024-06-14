<?php

use Api\Core\Router;
use Api\Core\Http\Request;

require_once dirname(__DIR__, 2) . "/autoload.php";

// TODO: endpoints to replace
//Api::get("suggest/reps/{exercise_type_id}", "Workouts", "suggestReps");
//Api::post("workouts/new",   "Workouts",         "save");

$request = Request::post();

$router = new Router();
$response = $router->handle($request);
$response->send();