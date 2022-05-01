<?php

/*
 * Models/User.php: a person that needs to authenticate
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Models;

use \Core\Database\Record;
use \Core\Database\Query;

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
    public function load()
    {
        $this->filter();
        $this->transform($this->transforms());

        $results = Query::select($this->table(), "*", $this->fields);

        // TODO If this select failes it may cause errors
        if (array_key_exists(0, $results))
        {
            // Save each properties to fields
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

    // Login user by verifying user via POST data and add an authentication
    // cookie to the Response.
    // return = bool
    public function login()
    {
        if ($this->load())
        {
            $this->createNewSession();
            return true;
        }

        return false;
    }

    // This function assumes the user has been loaded.
    // return = string (the cookie)
    public function createNewSession()
    {
        $cookie = new Session(["user_id" => $this->id]);
        if ($cookie->load())
        {
            $cookie->setExpiredCookie();
            $cookie->delete();
        }

        $newCookie = new Session(["user_id" => $this->id]);
        $newCookie->createNewCookie($this);
        $newCookie->addCookie();
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
