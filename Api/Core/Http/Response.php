<?php

/*
 * Core/Http/Response.php: define and send http responses
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Api\Core\Http;

class Response
{
    const JSON_CONTENT_TYPE = "Content-Type: application/json; charset=utf-8";

    
    // You can't explicitly delete cookies so just set them as expired. But
    // generally, this would be triggered because the client-side cookie had
    // expired and has already been deleted by the browser.
    public static function addExpiredCookie($map)
    {
        foreach ($map as $key => $value)
        {
            setcookie($key, $value, strtotime("-30 days"), "/");
        }
    }

    // The max size of a cookie values is 4K.
    public static function addCookie($map)
    {
        foreach ($map as $key => $value)
        {
            setcookie($key, $value, strtotime("+30 days"), "/");
        }
    }

    // $code = numeric
    // $date = string
    public static function send($code, $data = null)
    {
        header(self::JSON_CONTENT_TYPE);

        // CORS policy may be set in the server config. To set policy in PHP
        // you can set it here using:
        // header("Access-Control-Allow-Origin: " . $_ENV["ORIGIN"]);

        http_response_code($code);
        if (!is_null($data))
            echo json_encode($data);
    }

    public static function sendOk()
    {
        header(self::JSON_CONTENT_TYPE);

        // CORS policy may be set in the server config. To set policy in PHP
        // you can set it here using:
        // header("Access-Control-Allow-Origin: " . $_ENV["ORIGIN"]);

        http_response_code(Code::OK_200);
        echo json_encode(["ok" => "true"]);
    }

    public static function sendOkWithWarning($warning)
    {
        header(self::JSON_CONTENT_TYPE);

        // CORS policy may be set in the server config. To set policy in PHP
        // you can set it here using:
        // header("Access-Control-Allow-Origin: " . $_ENV["ORIGIN"]);

        http_response_code(Code::OK_200);
        echo json_encode(["ok" => "true", "warning" => $warning]);
    }

    public static function sendDefaultNotFound()
    {
        return self::send
        (
            Code::OK_200,
            [
                "ok" => "false",
                "error" => "true",
                "message" => "Not found",
                "code" => "404"
            ]
        );
    }
}
