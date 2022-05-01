<?php

/*
 * Models/Workout.php: Handle workout data for the Api
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Models;

use \Core\Database\Record;
use \Core\Utils\Date;

class Workout extends Record
{
    public function table()
    {
        return "workouts";
    }

    public function config()
    {
        return [
            "user_id" => function ($entry) {
                return is_numeric($entry);
            },
            "start" => function ($entry) {
                return is_numeric($entry);
            },
            "end" => function ($entry) {
                return is_numeric($entry);
            },
            "notes" => function ($entry) {
                return true;
            },
            "feel" => function ($entry) {
                return true;
            },
        ];
    }

    public function transforms()
    {
        return [
            "user_id" => function ($entry) {
                return (int) $entry;
            },
            "start" => function ($entry) {
                return Date::timestampToDatetime($entry);
            },
            "end" => function ($entry) {
                return Date::timestampToDatetime($entry);
            },
            "notes" => function ($entry) {
                return $entry;
            },
            "feel" => function ($entry) {
                return empty($entry) ? "average" : $entry;
            },
        ];
    }
}
