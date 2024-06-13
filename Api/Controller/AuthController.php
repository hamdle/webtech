<?php

/*
 * Class AuthController
 *
 * Control login and logout authentication.
 *
 * @author Eric Marty
 * @since 10/15/2023 6:38 PM
 */

namespace Api\Controller;

use Api\Core\Http\Request;
use Api\Core\Http\Response;
use Api\Model\User;
use Api\Form\LoginForm;
use Api\Core\Authentication\Session;
use Api\Rpc;

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
        $session = Rpc::getAuthenticationSession();
        $session->invalidateSession();

        $response = new Response();
        $response->setJson();
        return $response;
        //return Response::sendOk();
    }
}
