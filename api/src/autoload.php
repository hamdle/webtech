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

require_once __DIR__ . "/Core/Utils/Env.php";

use Core\Utils\Env;

class Autoload {
    public static function register()
    {
        Env::load();
        spl_autoload_register("Autoload::loadFile");
    }

    // $class = string (like "Core\Html\Request")
    // return = true if found | false if not
    public static function loadFile($class)
    {
        $file = __DIR__.DIRECTORY_SEPARATOR.
            str_replace("\\", DIRECTORY_SEPARATOR, $class).".php";

        if (file_exists($file))
        {
            require_once $file;
            return true;
        }

        return false;
    }
}

Autoload::register();
