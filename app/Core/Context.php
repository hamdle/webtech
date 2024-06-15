<?php

namespace App\Core;

class Context
{
    public static $context;

    public static function set($key, $context)
    {
        self::$context[$key] = $context;
    }

    public static function get($key)
    {
        return self::$context[$key];
    }
}