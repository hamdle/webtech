<?php

/*
 * Class User
 *
 * A user as represented by the database.
 *
 * @author Eric Marty
 * @since 12-16-2023 1:10 PM
 */

namespace api\Model;

use api\Core\Database\Record;

class User extends Record
{
    const TABLE = "users";

    public function __construct($fields = [])
    {
        parent::__construct($fields, self::TABLE);
    }

    public function databaseTransforms()
    {
        return [
            "email" => function ($entry) {
                return $entry;
            },
            "password" => function ($entry) {
                return empty($entry) ? null : md5($entry);
            },
        ];
    }
}
