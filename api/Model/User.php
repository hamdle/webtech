<?php

/*
 * Model/User.php: a person that needs to authenticate
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace api\Model;

use api\Core\Database\Record;
use api\Core\Database\Query;

class User extends Record
{
    // TODO should this be used instead?
    //const table = "users";

    public function table()
    {
        return "users";
    }

    // TODO this should be an abstract method defined by Record, and move this
    // down with the others
    // return = bool
    public function loadFromDatabase()
    {
        $this->filter();
        $this->transform();

        $results = Query::select($this->table(), "*", $this->fields);

        if (is_array($results) && array_key_exists(0, $results))
        {
            foreach ($results[0] as $key => $value)
            {
                $this->fields[$key] = $value;
            }
        }
        else
        {
            $this->messages[] = "User not found.";
            return false;
        }

        return true;
    }

    public function config()
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

    public function transforms()
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
