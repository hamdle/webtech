<?php

require_once dirname(__DIR__,1) . "/autoload.php";

class WorkoutApp {
    public $session;

    public function __construct() {
        $this->session = new \Models\Session();
    }
    public function run() {
        $this->session->tryLoadUser();

        $file = $_SERVER["REQUEST_URI"];     // eg "/home", "/home/page/"
        $file = str_replace('/','',$file);
        $file = empty($file)
            ? $_ENV["HOME_PAGE"]
            : ucwords(str_replace('/','',$file)).".php";
        $file = dirname(__DIR__,1).$_ENV["WEB_PAGE_DIR"].$file;
        $home = dirname(__DIR__,1).$_ENV["WEB_PAGE_DIR"].$_ENV["HOME_PAGE"];

        try {
            $this->tryRender($file)
                ?:$this->tryRenderOrDie($home);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            $this->tryRenderOrDie($home);
        }
    }

    private function tryRender($file) {
        if (file_exists($file)) {
            error_log("Loading file: ".$file);
            require $file;
            exit();
        }
    }

    private function tryRenderOrDie($page) {
        $this->tryRender($page);

        error_log($_ENV['ERROR_MESSAGE']);
        die($_ENV['ERROR_MESSAGE']);
    }
}

$app = new WorkoutApp();
$app->run();


?>
