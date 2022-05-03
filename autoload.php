<?php

/*
 * autoload.php: autoload files
 *
 * Autoload files based on their location in the web folder. To use a namespace
 * of \Core\Html\Request create a directory called Core and put a directory
 * called Html inside of it. Add file Request.php into the Html directory and
 * define the Request class in it.
 *
 * Copyright (C) 2021 Eric Marty
 */

require_once __DIR__ . "/api/Core/Utils/Env.php";

use Core\Utils\Env;

class Autoload {
    public static function register()
    {
        Env::load();
        spl_autoload_register("Autoload::loadServerFile");
    }

    // $class = string (like "Core\Html\Request")
    // return = true if found | false if not
    public static function loadServerFile($class)
    {
        $apiFile = __DIR__.DIRECTORY_SEPARATOR
            ."api".DIRECTORY_SEPARATOR
            .str_replace("\\", DIRECTORY_SEPARATOR, $class).".php";
        $serverFile = __DIR__.DIRECTORY_SEPARATOR.
            str_replace("\\", DIRECTORY_SEPARATOR, $class).".php";

        if (file_exists($apiFile)) {
            require_once $apiFile;
            return true;
        } else if (file_exists($serverFile)) {
            require_once $serverFile;
            return true;
        }

        return false;
    }
}

Autoload::register();