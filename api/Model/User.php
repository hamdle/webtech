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
    // TODO should this be used instead?
    //const table = "users";

    public function table()
    {
        return "users";
    }

    public function formFieldValidationConfig()
    {
        return [
            "email" => function ($entry) {
                if (empty($entry))
                    return "Email address should not be empty.";
                return true;
            },
            "password" => function ($entry) {
                if (empty($entry))
                    return "Password should not be empty.";
                return true;
            },
        ];
    }

    public function formFieldTransformConfig()
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
