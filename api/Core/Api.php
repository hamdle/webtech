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

namespace Core;

use \Core\Http\Response;
use \Core\Http\Request;
use \Core\Http\Code;
use \Core\Utils\Log;

class Api
{
    // The ring, an array of Api endpoints mapped to Controllers.
    private static $api;

    // Change this to put the Controllers in a different directory.
    private static $CONTROLLER_ROOT = "\\Controllers\\";

    //
    // Public methods
    //

    public static function get($endpoint, $controller, $function)
    {
        self::$api["get"][] = [$endpoint => [$controller, $function]];
    }

    public static function post($endpoint, $controller, $function)
    {
        self::$api["post"][] = [$endpoint => [$controller, $function]];
    }

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

    //
    // Private methods
    //

    // Given [$endpoint => $value], match the $endpoint to the request path and
    // return = $value or null
    private static function route()
    {
        $path = Request::path();
        $args = [];
        // TODO can you reduce the complexity of this?
        foreach (self::$api[Request::method()] ?? [] as $route)
        {
            foreach ($route as $uri => $controller)
            {
                $uriParts = explode("/", $uri);
                $pass = true;

                for ($i = 0; $i < count($uriParts); $i++)
                {
                    // Check number of parts
                    if (!(isset($path[$i]) &&
                        isset($uriParts[$i])))
                    {
                        $pass = false;
                    }
                    // Check part content
                    if ($path[$i] !== $uriParts[$i]) {
                        preg_match('#\{(.*?)\}#', $uriParts[$i], $match);
                        if (array_key_exists(1, $match)) {
                            $args[$match[1]] = $path[$i];
                        } else {
                            $pass = false;
                        }
                    }

                }
                if (!empty($args)) {
                    $controller[] = $args;
                }

                if ($pass)
                    return $controller;
            }
        }

        return null;
    }
}
