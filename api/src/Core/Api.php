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
    // The ring, an array of Api endpoints mapped to controllers.
    private static $api;

    // Change this to put the controllers in a different directory.
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
            // If found, this will be a tuple in the form [controller, function]
            $controllerParts = self::route();

            if (is_null($controllerParts))
                return Response::sendDefaultNotFound();

            $namespace = self::$CONTROLLER_ROOT.$controllerParts[0];
            $function = $controllerParts[1];

            if ($controller = [new $namespace, $function])
                return $controller();

            return Response::sendDefaultNotFound();
        }
        catch (\Throwable $e)
        {
            Log::error($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(), "Api::respond");
            return Response::send
            (
                Code::INTERNAL_SERVER_ERROR_500,
                [
                    "error" => true,
                    "message" => "An unexpected error has occurred",
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
        // TODO can you reduce the complexity of this?
        foreach (self::$api[Request::method()] ?? [] as $route)
        {
            foreach ($route as $uri => $controller)
            {
                $uriParts = explode("/", $uri);
                $pass = true;

                for ($i = 0; $i < count($uriParts); $i++)
                {
                    if (!(isset($path[$i]) &&
                        isset($uriParts[$i]) &&
                        $path[$i] == $uriParts[$i]))
                    {
                        $pass = false;
                    }
                }

                if ($pass)
                    return $controller;
            }
        }

        return null;
    }
}
