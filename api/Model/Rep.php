<?php

/*
 * Model/Rep.php: a single round of an exercise
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace api\Model;

use api\Core\Database\Record;

class Rep extends Record
{
    const TABLE = "reps";

    public function __construct($fields = [])
    {
        parent::__construct($fields, self::TABLE);
    }

    public function formFieldValidationConfig()
    {
        return [
            "exercise_id" => function ($entry) {
                return is_numeric($entry);
            },
            "amount" => function ($entry) {
                return is_numeric($entry);
            }
        ];
    }

    public function formFieldTransformConfig()
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
