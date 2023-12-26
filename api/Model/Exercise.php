<?php

/*
 * Class Exercise
 *
 * Model exercise data.
 *
 * @author Eric Jawaid Marty
 * @since 12/24/2023 12:05 PM
 */

namespace api\Model;

use api\Core\Database\Record;

class Exercise extends Record
{
    const TABLE = "exercises";

    public function __construct($fields = [])
    {
        parent::__construct($fields, self::TABLE);
    }

    public function fieldValidation()
    {
        return [
            "exercise_type_id" => function ($entry) {
                return is_numeric($entry);
            },
            "workout_id" => function ($entry) {
                return is_numeric($entry);
            },
            "user_id" => function ($entry) {
                return is_numeric($entry);
            },
            "sets" => function ($entry) {
                return is_numeric($entry);
            },
            "feedback" => function ($entry) {
                return true;
            },
        ];
    }

    public function databaseTransforms()
    {
        return [
            "exercise_type_id" => function ($entry) {
                return (int) $entry;
            },
            "workout_id" => function ($entry) {
                return (int) $entry;
            },
            "user_id" => function ($entry) {
                return (int) $entry;
            },
            "sets" => function ($entry) {
                return (int) $entry;
            },
            "feedback" => function ($entry) {
                // A query function to get a list of enum values for a field
                // would be nice TODO
                return in_array(trim($entry), ["up", "down", "none"])
                        ? trim($entry)
                        : "none";
            },
        ];
    }
}
