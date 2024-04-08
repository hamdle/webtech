<?php

/*
 * Class AuthController
 *
 * Control login and logout authentication.
 *
 * @author Eric Marty
 * @since 10/15/2023 6:38 PM
 */

namespace api\Controller;

use api\Core\Http\Request;
use api\Core\Http\Response;
use api\Model\User;
use api\Form\LoginForm;
use api\Core\Authentication\Session;
use api\Rpc;

class AuthController {
    // POST :: api/auth/login
    public function login()
    {
        $request = Request::post();
        $form = new LoginForm();
        $user = new User($request);
        $session = new Session();
        // TODO session_set_save_handler
        //if ($form->validate($request) &&
        //    $session["$user"])
        if ($form->validate($request) &&
            $user->loadFromDatabase() &&
            $session->authenticateLogin($user))
        {
            return Response::sendOk();
        }

        return Response::sendOkWithWarning("login failed");
    }

    // POST :: api/auth/logout
    public function logout()
    {
        $session = Rpc::getAuthenticationSession();
        $session->invalidateSession();

        return Response::sendOk();
    }
}
