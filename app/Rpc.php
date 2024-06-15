<?php

namespace Api;

use App\Core\Http\Code;
use App\Core\Http\Response;
use App\Core\Utils\Log;
use App\Core\Authentication\Session;
use App\Model\User;

class Rpc
{
    private static $CONTROLLER_ROOT = "\\app\\Controller\\";
    private static $CONTROLLER_FILE_EXT = "Controller";
    private static $request;
    private static Session $session;
    private static User $user;
    private static $publicEndpoints = [
        "Auth.login",
        "Auth.logout",
        'Page.test'
    ];
    private static $method;

    public static function handle($request)
    {
        self::$request = $request;
        $response = new Response();
        try {
            if (array_key_exists("method", $request))
            {
                self::$method = $request["method"];
                $parts = explode('.', self::$method);
                if (count($parts) === 2 && is_string($parts[0]) && is_string($parts[1]))
                {

                    $namespace = self::$CONTROLLER_ROOT.$parts[0].self::$CONTROLLER_FILE_EXT;
                    $function = $parts[1];
                    $args = array_filter($request, function ($key) {
                            return $key != 'method';
                        }, ARRAY_FILTER_USE_KEY);

                    $controller = [new $namespace, $function];
                    self::$session = new Session();
                    self::$session->authenticateUserFromCookie();
                    self::$user = self::$session->getAuthenticatedUser();
                    if (in_array(self::$method, self::$publicEndpoints))
                    {
                        $response = $controller($args);
                        return $response;
                    }
                    else if (isset(self::$user->id) !== null && is_numeric(self::$user->id))
                    {
                        $response = $controller($args);
                        return $response;
                    }
                    else
                    {
                        throw new \Exception("Authentication required to access endpoint ".self::$method);
                    }
                }
            }

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
//            return Response::send
//            (
//                Code::OK_200,
//                [
//                    "ok" => "false",
//                    "error" => "true",
//                    "message" => "An unexpected error has occurred"
//                ]
//            );
        }
    }

    public static function getRequest()
    {
        return self::$request;
    }

    public static function getUser()
    {
        return self::$user;
    }

    public static function getAuthenticationSession()
    {
        return self::$session;
    }
}