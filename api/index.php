<?php

/*
 * index.php: define the Api here
 *
 * Use the Api to map endpoints to controller functions by request type, as
 * done in this file. The Api will respond by routing the request to an
 * Api-defined function in a controller. Controllers return a Response and use
 * Models to read and write data. The Core contains general classes for
 * handling requests along with helper functions in Utils.
 *
 * index.php          - this file, the starting point
 *   web/
 *     Controllers/   - Put functions here that use data to respond to requests
 *     Modules/       - Database related classes go here, typically one per table
 *     Core/          - General functionality and helper classes
 *
 * Copyright (C) 2021 Eric Marty
 */

require __DIR__ . "/autoload.php";

use Core\Api;

Api::get("auth", "Authentication", "verifySession");
Api::get("exercises", "Workouts", "exerciseTypes");
Api::get("workouts", "Workouts", "allWorkouts");
Api::get("version", "AppInfo", "version");
Api::get("coffee", "AppInfo", "teapot");
Api::get("roll", "Dice", "d20");
Api::get("september", "September", "countdown");

Api::post("login", "Authentication", "login");
Api::post("workouts/new", "Workouts", "save");

return Api::respond();
