<?php

namespace App\Core;

use App\Core\Authentication\Session;
use App\Core\Http\Response;
use App\Core\Utils\Log;
use App\Core\Context;

class Router
{
    private static $CONTROLLER_ROOT = "\\app\\Controller\\";

    private static $CONTROLLER_FILE_EXT = "Controller";

    private static $publicEndpoints = [
        "Auth.login",
        "Auth.logout",
        'Page.login',
        "Picture.takepicture"
    ];

    public function handle($request)
    {
        $response = new Response();
        try {
            if (array_key_exists("method", $request))
            {
                $method = $request["method"];
                $parts = explode('.', $method);
                if (count($parts) === 2 && is_string($parts[0]) && is_string($parts[1]))
                {

                    $namespace = self::$CONTROLLER_ROOT.$parts[0].self::$CONTROLLER_FILE_EXT;
                    $function = $parts[1];
//                    $args = array_filter($request, function ($key) {
//                        return $key != 'method';
//                    }, ARRAY_FILTER_USE_KEY);
                    $args = $request;

                    $controller = [new $namespace, $function];
                    $session = new Session();
                    $session->authenticateUserFromCookie();
                    Context::set('session', $session);
                    $user = $session->getAuthenticatedUser();
                    Context::set('user', $user);
                    if (in_array($method, self::$publicEndpoints))
                    {
                        $response = $controller($args);
                        return $response;
                    }
                    else if (isset($user->id) !== null && is_numeric($user->id))
                    {
                        $response = $controller($args);
                        return $response;
                    }
                    else
                    {
                        throw new \Exception("Authentication required to access endpoint ".$method);
                    }
                }
            }

            $response->setJson();
            $response->setError('Not found');
            return $response;
            //return Response::sendDefaultNotFound();
        }
        catch (\Throwable $e)
        {
            Log::error($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(), "Rpc::handle");
            $response->setJson();
            $response->setError('An unexpected error has occurred');
            return $response;
        }
    }
}