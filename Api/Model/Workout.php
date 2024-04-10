<?php

/*
 * Class Workout
 *
 * Model user workout.
 *
 * @author Eric Jawaid Marty
 * @since 12/24/2023 12:02 PM
 */

namespace Api\Model;

use Api\Core\Database\Record;
use Api\Core\Utils\Date;

class Workout extends Record
{
    const TABLE = "workouts";

    public function __construct($fields = [])
    {
        parent::__construct($fields, self::TABLE);
    }

    public function databaseTransforms()
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
