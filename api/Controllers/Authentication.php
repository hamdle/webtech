<?php

/*
 * Controllers/Authentication.php: handle user authentication requests
 *
 * This controller should verify cookies and handle user login details.
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Controllers;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Code;
use Models\User;
use Models\Session;

class Authentication {
    // return = \Http\Response
    public function login()
    {
        $user = new User(Request::post());
        if (!$user->validate())
            return Response::send(Code::UNPROCESSABLE_ENTITY_422, $user->getMessages());

        if ($user->login())
            return Response::send(Code::OK_200, [
                "ok" => "true"
            ]);

        return Response::send(Code::OK_200, [
            "ok" => "true",
            "warning" => "login failed"
        ]);
    }

    public function logout()
    {
        $session = new Session();
        if ($session->tryLoadUser()) {
            $session->setExpiredCookie();
            $session->delete();
        }
        return Response::send(Code::DELETED_204);
    }

    // The browser will send the cookie used to verify the session automatically.
    // return = \Http\Response
    public static function verifySession()
    {
        $session = new Session();
        if ($session->tryLoadUser())
            return Response::send(Code::OK_200);

        return Response::send(Code::UNAUTHORIZED_401);
    }
}
