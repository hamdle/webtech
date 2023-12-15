<?php

namespace app;

require_once dirname(__DIR__, 1) . "/autoload.php";

use api\Model\Session;

class Core
{
    public const HTML_CLOSE = "close";
    public const HTML_FOOTER = "footer";
    public const HTML_HEADER = "header";
    public const HTML_OPEN = "open";
    public const HTML_ERROR = "error";
    public readonly Session $session;

    private const AUTHENTICATION_ERROR_MESSAGE = 'Authentication error';
    private $name;

    public function __construct($name = "Workout")
    {
        $this->name = $name;
        $this->session = new Session();
        try
        {
            $this->handleAuthentication();
        }
        catch (\Exception $e)
        {
            error_log($e->getMessage());
            $this->renderHtml(self::HTML_OPEN);
            $this->renderHtml(self::HTML_ERROR);
            $this->renderHtml(self::HTML_CLOSE);
            die();
        }
    }

    private function handleAuthentication()
    {
        if ($_SERVER["REQUEST_URI"] === "/" ||
            $this->session->authenticated() ||
            $this->session->loadUser())
        {
            return;
        }
        else
        {
            throw new \Exception(self::AUTHENTICATION_ERROR_MESSAGE);
        }
    }

    public function renderHtml($file)
    {
        $filepath = dirname(__DIR__, 1) . $_ENV["HTML_DIR"] . $file . ".php";
        if (file_exists($filepath))
        {
            require $filepath;
        }
    }

    public function onPage($uri)
    {
        return $_SERVER["REQUEST_URI"] === "/"
            ? false
            : str_contains($_SERVER["REQUEST_URI"], $uri);
    }
}
?>