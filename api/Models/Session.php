<?php

/*
 * Models/Session.php: a user session
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Models;

use Core\Http\Request;
use Core\Http\Response;
use Core\Database\Record;
use Core\Database\Query;
use \Core\Database;

class Session extends Record
{
    const COOKIE_KEY = "Session-Id";

    private $verified = false;

    public function table()
    {
        return "sessions";
    }

    // Attempt to load a session using the fields assigned to this session.
    // return = true | false and a message will be set if the session fails to load
    public function load()
    {
        $this->filter();
        $this->transform($this->transforms());

        $records = Database::execute('session.sql', $this->fields);

        if (!is_null($records) && array_key_exists(0, $records))
        {
            foreach ($records[0] as $field => $value)
            {
                $this->fields[$field] = $value;
            }
        }
        else
        {
            $this->messages[] = "Session not found.";
            return false;
        }

        return true;
    }

    public function delete()
    {
        Database::execute('delete-session.sql', [
            'id' => $this->id
        ]);
        $this->fields = [];
    }

    // $user = \Models\User
    public function createNewCookie($user)
    {
        $token = bin2hex(random_bytes(128));
        $cookie = $user->email.":".$token;
        $mac = hash_hmac("sha256", $cookie, $_ENV["COOKIE_KEY"]);
        $cookie .= ":".$mac;

        $this->user_id = $user->id;
        $this->token = $token;
        $this->save();

        $this->cookie = $cookie;
    }

    // Add cookie to the global Response
    public function addCookie()
    {
        Response::addCookie([self::COOKIE_KEY => $this->cookie]);
    }

    // Verify that a cookie sent from the client is valid. If the cookie is
    // valid, the verified user (of type \Models\User) will be added to the
    // session's fields.
    // return = bool
    public function tryLoadUser()
    {
        foreach (Request::cookie() as $key => $value) {
            if (strcmp($key, self::COOKIE_KEY) !== 0)
                continue;

            $parts = explode(":", $value);
            if (count($parts) !== 3)
                return false;

            $user = new User(["email" => $parts[0]]);
            if (!$user->load())
                return false;

            $this->user_id = $user->id;
            if (!$this->load())
            {
                $this->setExpiredCookie();
                return false;
            }
            $this->user = $user;

            // The final cookie value will be in the form of "email:token:mac".
            // Where the email and token combine with a key from the .env to
            // create the mac.
            $this->cookie = $user->email.":".$this->token;
            $mac = hash_hmac("sha256", $this->cookie, $_ENV["COOKIE_KEY"]);

            if (hash_equals($mac, $parts[2])) {
                $this->verified = true;
                return true;
            }

        }

        $this->verified = false;
        return false;
    }

    // Delete a cookie on the client by setting it as expired.
    public function setExpiredCookie()
    {
        Response::addExpiredCookie([self::COOKIE_KEY => $this->cookie]);
    }

    public function verified() {
        return $this->verified;
    }

    public function config()
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

    public function transforms()
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
