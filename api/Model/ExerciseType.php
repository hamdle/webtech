<?php

/*
 * Model/ExerciseType.php: handle exercise type data requests
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace api\Model;

use api\Core\Database\Record;
use api\Core\Database\Query;

class ExerciseType extends Record
{
    public function table()
    {
        return "exercise_types";
    }

    public function all()
    {
        return Query::select($this->table(), "*");
    }

    public function config()
    {
        return [];
    }

    public function transforms()
    {
        return [];
    }
}
