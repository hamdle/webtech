<?php

use \Models\Session;

class App {

    private Session $session;

    private string $title;
    private array $menu;

    public function __construct() {
        $this->session  = new Session();
        $this->title = "Welcome";
        $this->menu = [];
    }

    public function run() {
        try {
            $this->session->tryLoadUser();

            $file = str_replace('/','',$_SERVER["REQUEST_URI"]);
            $file = empty($file)
                ? $_ENV["HOME_PAGE"]
                : str_replace('/','',$file).".php";

            $this->tryRender($file)
                ?:$this->tryRenderOrDie($this->session->authenticated() ? $_ENV["404_PAGE"] : $_ENV["HOME_PAGE"]);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            $this->tryRenderOrDie($_ENV["HOME_PAGE"]);
        }
    }

    private function tryRender($file) {
        $filepath = $this->page($file);
        if (file_exists($filepath)) {
            error_log("Rendering: ".$filepath);
            require $filepath;
            exit();
        }
    }

    private function tryRenderOrDie($file) {
        $this->tryRender($file);
        error_log($_ENV['ERROR_MESSAGE']);
        die($_ENV['ERROR_MESSAGE']);
    }

    private function tryRenderTemplate($file) {
        $filepath = $this->template($file);
        if (file_exists($filepath)) {
            error_log("Rendering: ".$filepath);
            require $filepath;
        }
    }

    private function page($file) {
        return __DIR__.$_ENV["PAGE_DIR"].$file;
    }

    private function template($file) {
        return __DIR__.$_ENV["TEMPLATE_DIR"].$file;
    }
}

?>