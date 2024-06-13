<?php

namespace Api\Core\Utils;

class Helper
{
    public static function onPage($uri): bool
    {
        return $_SERVER["REQUEST_URI"] === "/"
            ? false
            : str_contains($_SERVER["REQUEST_URI"], $uri);
    }

    public static function isAuthenticated()
    {
        return false;
        //return $this->session->isAuthenticated();
    }
}