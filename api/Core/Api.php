<?php

/*
 * Core/Api.php: holder of the ring
 *
 * One class to run them all. The Api maintains an internal array ($api) that
 * maps endpoints to functions in Controllers. The Api matches the request to
 * an endpoint and calls the appropriate Controller function. If no match is
 * found or an error occurs the Api will return an appropriate response.
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace api\Core;

use api\Core\Http\Response;
use api\Core\Http\Request;
use api\Core\Http\Code;
use api\Core\Utils\Log;

class Api
{
    private static $CONTROLLER_ROOT = "\\api\\Controllers\\";

    // This is the surface, uncaught exceptions can bubble up to here.
    // return = \Core\Http\Response
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
