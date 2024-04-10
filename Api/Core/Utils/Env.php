<?php

/*
 * Class Env
 *
 * Load $_ENV global and load into putenv() so getenv() can be used safely.
 *
 * @author Eric Marty
 * @since 10/15/2023 6:47 PM
 */

namespace Api\Core\Utils;

use Exception;

class Env
{
    /**
     * Load the contents of a .env file and set environment variables.
     *
     * @param string|null $path The path to the .env file. If null, the default path will be used.
     * @throws Exception If the .env file is empty or cannot be read.
     */
    public static function load($path = null)
    {
        try {
            $pathParts = explode("/", $_SERVER["DOCUMENT_ROOT"]);
            $web = $pathParts[count($pathParts)-1];
            if (strcmp($web, "public_html") !== 0) {
                if (empty($_SERVER["DOCUMENT_ROOT"])) {
                    // This is a script
                    $output = file_get_contents(dirname(__FILE__, 4) . "/.env");
                } else {
                    // This call came from within this Api project
                    $output = file_get_contents(
                        $path ?? dirname($_SERVER["DOCUMENT_ROOT"],1) . "/.env");
                }
            } else {
                // This call is from outside of the Api project and came from the parent public_html application who uses this
                // API. You can find this file starting from the root of the parent project at /public_html/index.php
                $output = file_get_contents(
                    $path ?? dirname($_SERVER["DOCUMENT_ROOT"],1) . "/.env");
            }

            if ($output === false || $output == "")
                throw new Exception();
        } catch (Exception $e) {
            print "No file found. Create .env or update permissions.";
            exit;
        }

        $fileContent = explode(PHP_EOL, $output);
        $fileContent = array_filter($fileContent);
        $lineNumber = 0;

        foreach ($fileContent as $line)
        {
            $lineNumber++;
            if ($line[0] == "#")
                continue;

            $keyVal = explode("=", $line);

            if (isset($keyVal[0]) && isset($keyVal[1]))
            {
                $_ENV[$keyVal[0]] = $keyVal[1];
                putenv($keyVal[0]."=".$keyVal[1]);
            }
            else
            {
                echo "Unable to parse line {$lineNumber} of the .env.";
            }
        }
    }
}
