<?php

/*
 * Core/Utils/Log.php: print messages to the PHP's error log
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Core\Utils;

class Log {
    // Sends an error message to the public_html web's error log or to a file.
    public static function error($value = null, $tag = "")
    {
        error_log("__".($tag ?? "START")."__< ".print_r($value, true)." >__".
            ($tag ?? "END")."__");
    }
}
