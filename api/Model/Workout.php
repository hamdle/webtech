<?php

/*
 * Model/Go.php: Handle workout data for the Api
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace api\Model;

use api\Core\Database\Record;
use api\Core\Utils\Date;

class Workout extends Record
{
    const TABLE = "workouts";

    public function __construct($fields = [])
    {
        parent::__construct($fields, self::TABLE);
    }

    public function formFieldValidationConfig()
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

    public function formFieldTransformConfig()
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
