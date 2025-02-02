<?php

/*
 * Class ExerciseType
 *
 * Exercises that can be preformed during a workout.
 *
 * @author Eric Marty
 * @since 12/16/2023
 */

namespace App\Model;

use App\Core\Database\Record;
use App\Core\Database\Database;

class ExerciseType extends Record
{
    const TABLE = "exercise_types";

    public function __construct($fields = [])
    {
        parent::__construct($fields, self::TABLE);
    }

    public function all()
    {
        return Database::select(self::TABLE, "*");
    }

    public function databaseTransforms()
    {
        return [];
    }
}
