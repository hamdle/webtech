<?php

/*
 * Class User
 *
 * A user as represented by the database.
 *
 * @author Eric Marty
 * @since 12-16-2023 1:10 PM
 */

namespace Api\Model;

use Api\Core\Database\Record;

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
            "id" => function ($entry) {
                return $entry;
            },
            "email" => function ($entry) {
                return $entry;
            },
            "password" => function ($entry) {
                return empty($entry) ? null : md5($entry);
            },
            "first_name" => function ($entry) {
                return htmlspecialchars(substr($entry, 0, 128), ENT_QUOTES, "UTF-8");
            },
            "last_name" => function ($entry) {
                return htmlspecialchars(substr($entry, 0, 128), ENT_QUOTES, "UTF-8");
            }
        ];
    }
}
