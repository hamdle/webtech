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
    /**
     * Logs in a user by verifying input fields, loading user data from the database,
     * and authenticating the user session.
     *
     * @return Response The response object containing the login result.
     * @throws Exception If an error occurs during the login process.
     */
    public function login()
    {
        $request = Request::post();
        $form = new LoginForm();
        $user = new User($request);
        $session = new Session();
        if ($form->validate($request) &&
            $user->loadFromDatabase() &&
            $session->authenticateLogin($user))
        {
            return Response::sendOk();
        }

        return Response::sendOkWithWarning("login failed");
    }

    /**
     * Logs out the user by invalidating the current session.
     *
     * @return Response A response indicating successful logout.
     */
    public function logout()
    {
        $session = Rpc::getAuthenticationSession();
        $session->invalidateSession();

        return Response::sendOk();
    }
}
