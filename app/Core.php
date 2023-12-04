<?php

namespace app;

require_once dirname(__DIR__, 1) . "/autoload.php";

use Models\Session;
use Models\User;

class Core
{
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

        $uri = str_replace('/', '', $_SERVER["REQUEST_URI"]);
        $this->uri = $uri;
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
        $filepath = dirname(__DIR__, 1) . $_ENV["PART_DIR"] . $file;
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
    }

    public function title($title)
    {
        $this->title = $title;
    }
}
?>