<?php

/*
 * Models/Rep.php: a single round of an exercise
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Models;

use Core\Database\Record;

class Rep extends Record
{
    public function table()
    {
        return "reps";
    }

    public function config()
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

    public function transforms()
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
