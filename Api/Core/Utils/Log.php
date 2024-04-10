<?php

/*
 * Class Log
 *
 * Log errors to php log, database.
 *
 * @author Eric Marty
 * @since 12/26/2023 12:03 PM
 */

namespace Api\Core\Utils;

use Api\Core\Database\Database;

class Log {
    public static function system($value = null, $tag = null)
    {
        self::log($value, $tag,"system", 1);
    }

    public static function error($value = null, $tag = null)
    {
        self::log($value, $tag,"error", 1);
    }

    public static function info($value = null, $tag = null)
    {
        self::log($value, $tag,"info", 1);
    }

    private static function log($value, $tag, $type, $user)
    {
        $msg = print_r($value, true);
        error_log(($tag ? "\n<----- " . $tag . " ----->" : "") . PHP_EOL . $msg . PHP_EOL);
        Database::log($msg, $type, $user);
    }
}
