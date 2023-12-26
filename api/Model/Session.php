<?php

/*
 * Model/Session.php: a user session
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace api\Model;

use api\Core\Database\Database;
use api\Core\Database\Record;
use api\Core\Http\Request;
use api\Core\Http\Response;

class Session extends Record
{
    const TABLE = "sessions";
    const COOKIE_KEY = "Session-Id";

    public function __construct($fields = [])
    {
        parent::__construct($fields, self::TABLE);
    }

    public function delete()
    {
        if ($this->id)
        {
            // TODO should delete all sessions for a user
            // since multiple sessions in the database for
            // one user will cause auth failure?
            Database::execute('delete-session.sql', [
                'id' => $this->id
            ]);
        }
        $this->fields = [];
    }

    // TODO refactor out this method, use Authentication/Session.php
    public function loadUser()
    {
        foreach (Request::cookie() as $key => $value) {
            if (strcmp($key, self::COOKIE_KEY) !== 0)
                continue;

            $parts = explode(":", $value);
            if (count($parts) !== 3)
            {
                return false;
            }

            $user = new User(["email" => $parts[0]]);
            if (!$user->loadFromDatabase())
            {
                return false;
            }

            $this->user_id = $user->id;
            if (!$this->loadFromDatabase())
            {
                Response::addExpiredCookie([self::COOKIE_KEY => $this->cookie]);
                return false;
            }
            $this->user = $user;

            // The final cookie value will be in the form of "email:token:mac".
            // Where the email and token combine with a key from the .env to
            // create the mac.
            $this->cookie = $user->email.":".$this->token;
            $mac = hash_hmac("sha256", $this->cookie, $_ENV["COOKIE_KEY"]);

            if (hash_equals($mac, $parts[2]))
            {
                return true;
            }
        }

        return false;
    }

    public function fieldValidation()
    {
        return [
            "user_id" => function ($entry) {
                if (empty($entry))
                    return "User ID should not be empty.";
                return true;
            },
            "token" => function ($entry) {
                if (empty($entry))
                    return "Token should not be empty.";
                return true;
            },
        ];
    }

    public function databaseTransforms()
    {
        return [
            "user_id" => function ($entry) {
                return $entry;
            },
            "token" => function ($entry) {
                return $entry;
            },
        ];
    }
}
