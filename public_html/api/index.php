<?php

require_once dirname(__DIR__, 2) . "/autoload.php";

use api\Core\Api;

// TODO: endpoints to replace
//Api::get("auth",        "Authentication",   "verifySession");
//Api::get("exercises",   "Workouts",         "exerciseTypes");
//Api::get("workouts",    "Workouts",         "allWorkouts");
//Api::get("version",     "AppInfo",          "version");
//Api::get("coffee",      "AppInfo",          "teapot");
//Api::get("roll",        "Dice",             "d20");
//Api::get("september",   "September",        "countdown");
//Api::get("suggest/reps/{exercise_type_id}", "Workouts", "suggestReps");
//Api::post("workouts/new",   "Workouts",         "save");

return Api::respond();