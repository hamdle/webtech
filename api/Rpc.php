<?php

namespace api;

use api\Core\Http\Code;
use api\Core\Http\Response;
use api\Core\Utils\Log;
use api\Core\Authentication\Session;
use api\Model\User;

class Rpc
{
    private static $CONTROLLER_ROOT = "\\api\\Controller\\";
    private static $CONTROLLER_FILE_EXT = "Controller";
    private static Session $session;
    private static User $user;
    private static $publicEndpoints = [
        "Auth.login"
    ];
    private static $method;

    public static function handle($request)
    {
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
                        if (in_array(self::$method, self::$publicEndpoints))
                        {
                            return $controller($args);
                        }
                        else if (self::$session->authenticateUserFromCookie())
                        {
                            self::$user = self::$session->getAuthenticatedUser();
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

    public static function getUser()
    {
        return self::$user;
    }

    public static function getAuthenticationSession()
    {
        return self::$session;
    }
}