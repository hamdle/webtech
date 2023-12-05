<?php

/*
 * Core/Http/Request.php: http request information
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace api\Core\Http;

use api\Core\Utils\Log;

class Request
{
    private static $CONTROLLER_ROOT = "\\api\\Controllers\\";

    public static function uri()
    {
        return $_SERVER["REQUEST_URI"];
    }

    // Return the path parts.
    // return = array
    public static function path()
    {
        $parts = array_filter(
            explode("/", self::uri()),
            function($part)
            {
                if (empty(trim($part)) || $part == "api")
                    return 0;
                return 1;
            }
        );

        return array_values($parts);
    }

    public static function method()
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    // File upload data
    // return = mixed
    public static function complexData()
    {
        return json_decode(file_get_contents("php://input"), true);
    }

    public static function post()
    {
        return $_POST;
    }

    public static function cookie()
    {
        return $_COOKIE;
    }

    public static function respond()
    {
        try {
            $request = Request::post();
            if (empty($request)) {
                $request = Request::complexData();
            }

            $method = $request['method'] ?? null;
            if (is_null($method))
                return Response::sendDefaultNotFound();

            $parts = explode('.', $method);
            if (count($parts) != 2)
                return Response::sendDefaultNotFound();
            $namespace = self::$CONTROLLER_ROOT.$parts[0];
            $function = $parts[1];

            // Format args as key => value pairs
            $args = array_filter($request, function ($key) {
                return $key != 'method';
            },ARRAY_FILTER_USE_KEY);

            if ($controller = [new $namespace, $function])
                return $controller($args);

            return Response::sendDefaultNotFound();
        }
        catch (\Throwable $e)
        {
            Log::error($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(), "Api::respond");
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
}
