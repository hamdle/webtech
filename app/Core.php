<?php

namespace app;

require_once dirname(__DIR__, 1) . "/autoload.php";

use api\Models\Session;

class Core
{
    public const HTML_CLOSE = 'close';
    public const HTML_FOOTER = 'footer';
    public const HTML_HEADER = 'header';
    public const HTML_OPEN = 'open';
    public readonly Session $session;

    private $name;

    public function __construct($name = "Workout")
    {
        $this->session = new Session([], true);
        $this->name = $name;
    }

    public function authOrDie($message = 'Authentication error')
    {
        if (!$this->session->authenticated())
        {
            error_log($message);
            die($message);
        }
    }

    public function renderHtml($file)
    {
        $filepath = dirname(__DIR__, 1) . $_ENV["HTML_DIR"] . $file . '.php';
        if (file_exists($filepath))
        {
            require $filepath;
        }
    }

    public function onPage($uri)
    {
        if ($_SERVER["REQUEST_URI"] === "/")
        {
            return false;
        }
        else if (str_contains($_SERVER["REQUEST_URI"], $uri))
        {
            return true;
        }
        return false;
    }
}
?>