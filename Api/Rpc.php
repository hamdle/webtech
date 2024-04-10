<?php

namespace api;

use Api\Core\Http\Code;
use Api\Core\Http\Response;
use Api\Core\Utils\Log;
use Api\Core\Authentication\Session;
use Api\Model\User;

class Rpc
{
    private static $CONTROLLER_ROOT = "\\Api\\Controller\\";
    private static $CONTROLLER_FILE_EXT = "Controller";
    private static $request;
    private static Session $session;
    private static User $user;
    private static $publicEndpoints = [
        "Auth.login",
        "Auth.logout"
    ];
    private static $method;

    public static function handle($request)
    {
        self::$request = $request;
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

                    if ($controller = [new $namespace, $function])
                    {
                        self::$session = new Session();
                        self::$session->authenticateUserFromCookie();
                        self::$user = self::$session->getAuthenticatedUser();
                        if (in_array(self::$method, self::$publicEndpoints))
                        {
                            return $controller($args);
                        }
                        else if (isset(self::$user->id) !== null && is_numeric(self::$user->id))
                        {
                            return $controller($args);
                        }
                        else
                        {
                            throw new \Exception("Authentication required to access endpoint ".self::$method);
                        }
                    }
                }
            }

            return Response::sendDefaultNotFound();
        }
        catch (\Throwable $e)
        {
            Log::error($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(), "Rpc::handle");
            return Response::send
            (
                Code::OK_200,
                [
                    "ok" => "false",
                    "error" => "true",
                    "message" => "An unexpected error has occurred"
                ]
            );
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