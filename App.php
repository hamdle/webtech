<?php

require_once __DIR__ . "/autoload.php";

use \Models\Session;
use \Models\User;

class App {
    private Session $Session;
    private ?User $User;
    private array $Attributes;

    public function __construct()
    {
        $this->Init();
    }

    public function Init()
    {
        $this->Session  = new Session();
        $this->Session->tryLoadUser();
        $this->User = $this->Session->user;

        $this->Attributes["title"] = "Welcome";
        $this->Attributes["menu"] = [];

        // TODO: Middleware goes here
    }

    public function Run()
    {
        $file = str_replace('/','',$_SERVER["REQUEST_URI"]);
        $file = empty($file)
            ? $_ENV["HOME_PAGE"]
            : str_replace('/','',$file).".php";

        $this->Attributes["file"] = $file;

        try
        {
            $this->TryRenderPage($file)
                ?:$this->RenderOrDie($this->Session->Authenticated() ? $_ENV["404_PAGE"] : $_ENV["HOME_PAGE"]);
        }
        catch (\Throwable $e)
        {
            error_log($e->getMessage());
            $this->RenderOrDie($_ENV["HOME_PAGE"]);
        }
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
        if ($uri === "/" && $this->Attributes["file"] === $_ENV["HOME_PAGE"])
        {
            return true;
        }

        $e = explode(".", $this->Attributes["file"]);
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

// APP STARTS HERE
////////////////////////////////
$App = new App();
$App->Run();

?>