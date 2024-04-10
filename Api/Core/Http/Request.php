<?php

/*
 * Core/Http/Request.php: http request information
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Api\Core\Http;

use Api\Core\Utils\Log;

class Request
{
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
        return empty($_POST)
            ? self::complexData()
            : $_POST;
    }

    public static function cookie()
    {
        return $_COOKIE;
    }
}
