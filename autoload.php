<?php

/*
 * Autoload
 *
 * Autoload files based on their location from the root directory.
 *
 * @author Eric Marty
 * @since 12/4/2023
 */

use api\Core\Utils\Env;

require_once __DIR__ . "/Api/Core/Utils/Env.php";

class Autoload {
    public static function register()
    {
        Env::load();
        spl_autoload_register("Autoload::loadClassFile");
    }

    // $class = string like "api\Core\Html\Request"
    public static function loadClassFile($class)
    {
        $file = __DIR__."/". str_replace("\\", "/", $class).".php";
        if (file_exists($file))
        {
            require_once $file;
            return true;
        }
        return false;
    }
}

Autoload::register();