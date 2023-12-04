<?php

namespace app;

require_once dirname(__DIR__, 1) . "/autoload.php";

use Models\Session;
use Models\User;

class Core
{

    public const HTML_CLOSE = 'close';
    public const HTML_FOOTER = 'footer';
    public const HTML_HEADER = 'header';
    public const HTML_OPEN = 'open';

    private Session $Session;
    public ?User $User;
    private $uri;
    private $title;

    public function __construct()
    {
        $this->Session = new Session();
        $this->Session->loadUser();
        $this->User = $this->Session->user;
        $this->title = "Welcome";
        $this->uri = str_replace('/', '', $_SERVER["REQUEST_URI"]);
    }

    public function authOrDie($message = 'Authentication error')
    {
        if (!$this->Session->Authenticated())
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
        if ($uri === "/" || empty($this->uri))
        {
            return false;
        }
        else if (str_contains($uri, $this->uri))
        {
            return true;
        }
        return false;
    }

    public function title($title)
    {
        $this->title = $title;
    }
}
?>