<?php

/*
 * Class Timesheet
 *
 * A timesheet from Timelog application.
 *
 * @author Eric Marty
 * @since 7/5/2024 8:37 PM
 */

namespace App\Model;

use App\Core\Database\Record;

class Timesheet extends Record
{
    const TABLE = "timesheet";

    public function __construct($fields = [])
    {
        parent::__construct($fields, self::TABLE);
    }

    public function databaseTransforms()
    {
        return [
            "id" => function ($entry) {
                return $entry;
            },
            "user_id" => function ($entry) {
                return $entry;
            },
            "file" => function ($entry) {
                return $entry;
            },
            "tag" => function ($entry) {
                return $entry;
            }
        ];
    }
}
