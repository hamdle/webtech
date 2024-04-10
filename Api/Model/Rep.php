<?php

/*
 * Class Rep
 *
 * Model a single round of an exercise.
 *
 * @author Eric Jawaid Marty
 * @since 12/24/2023 12:03 PM
 */

namespace Api\Model;

use Api\Core\Database\Record;

class Rep extends Record
{
    const TABLE = "reps";

    public function __construct($fields = [])
    {
        parent::__construct($fields, self::TABLE);
    }

    public function databaseTransforms()
    {
        return [
            "exercise_id" => function ($entry) {
                return (int) $entry;
            },
            "amount" => function ($entry) {
                return (int) $entry;
            }
        ];
    }
}
