<?php

require_once __DIR__ . "/autoload.php";

use \Models\Session;
use \Models\User;

class App {
    private Session $Session;
    public ?User $User;
    private $file;

    public $title;

    public function __construct()
    {
        $this->Init();
    }

    public function Init()
    {
        $this->Session  = new Session();
        $this->Session->tryLoadUser();
        $this->User = $this->Session->user;

        $this->title = "Welcome";

        $file = str_replace('/','',$_SERVER["REQUEST_URI"]);
        $file = str_replace('/','',$file).".php";

        $this->file = $file;

        // TODO: Middleware goes here
    }

    public function IsAuthenticated()
    {
        if (!$this->Session->Authenticated())
        {
            return $this->RenderOrDie($_ENV["HOME_PAGE"]);
        }
    }

    public function RedirectAuthenticated($file)
    {
        if ($this->Session->Authenticated())
        {
            $e = explode(".", $file);
            header("Location: ".$_ENV["ORIGIN"]."/".( empty($e)?:$e[0] ));
        }
    }

    public function RenderHtml($file)
    {
        $this->TryRenderPage($file);
        $this->TryRenderPart($file);
    }

    public function IsSelected($uri)
    {
        if ($uri === "/" && $this->file === $_ENV["HOME_PAGE"])
        {
            return true;
        }

        $e = explode(".", $this->file);
        if (str_contains($uri, (empty($e)?:$e[0] )))
        {
            return true;
        }
    }

    private function TryRenderPage($file)
    {
        $filepath = __DIR__.$_ENV["PAGE_DIR"].$file;
        if (file_exists($filepath)) {
            //error_log("Rendering: ".$filepath);
            require $filepath;
            exit();
        }
    }

    private function TryRenderPart($file)
    {
        $filepath = __DIR__.$_ENV["PART_DIR"].$file;
        if (file_exists($filepath)) {
            //error_log("Rendering: ".$filepath);
            require $filepath;
        }
    }

    private function RenderOrDie($file)
    {
        $this->RenderHtml($file);
        error_log($_ENV['RENDER_OR_DIE_ERROR_MESSAGE']);
        die($_ENV['RENDER_OR_DIE_ERROR_MESSAGE']);
    }
}

?>