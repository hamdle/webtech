<?php

/*
 * Class AuthController
 *
 * Control login and logout authentication.
 *
 * @author Eric Marty
 * @since 10/15/2023 6:38 PM
 */

namespace App\Controller;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Model\User;
use App\Form\LoginForm;
use App\Core\Authentication\Session;
use App\Rpc;

class AuthController {
    // POST :: api/auth/login
    public function login()
    {
        //$request = Request::post();
        $response = new Response();
        $response->setJson();

        $form = new LoginForm();
        $user = new User(Request::post());
        $session = new Session();
        // TODO session_set_save_handler
        //if ($form->validate($request) &&
        //    $session["$user"])
        if ($form->validate(Request::post()) &&
            $user->loadFromDatabase() &&
            $session->authenticateLogin($user))
        {
            return $response;
        }

        $response->setWarn('login failed');
        return $response;
        //return Response::sendOkWithWarning("login failed");
    }

    // POST :: api/auth/logout
    public function logout()
    {
        $session = \App\Core\Context::get('session');
        $session->invalidateSession();

        $response = new Response();
        $response->setJson();
        return $response;
        //return Response::sendOk();
    }
}
