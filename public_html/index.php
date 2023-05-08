<?php

require_once dirname(__DIR__,1) . "/autoload.php";

class WorkoutApp {
    public $session;
    public $home;
    public $file404;

    public function __construct() {
        $this->session  = new \Models\Session();
        $this->home     = dirname(__DIR__,1).$_ENV["WEB_PAGE_DIR"].$_ENV["HOME_PAGE"];
        $this->file404  = dirname(__DIR__,1).$_ENV["WEB_PAGE_DIR"].$_ENV["404_PAGE"];
    }
    public function run() {
        $this->session->tryLoadUser();

        $file = $_SERVER["REQUEST_URI"];     // eg "/home", "/home/page/"
        $file = str_replace('/','',$file);
        $file = empty($file)
            ? $_ENV["HOME_PAGE"]
            : ucwords(str_replace('/','',$file)).".php";
        $file = dirname(__DIR__,1).$_ENV["WEB_PAGE_DIR"].$file;

        try {
            $this->tryRender($file)
                ?:$this->tryRenderOrDie($this->session->verified() ? $this->file404 : $this->home);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            $this->tryRenderOrDie($this->home);
        }
    }

    private function tryRender($page) {
        if (file_exists($page)) {
            error_log("Rendering page: ".$page);
            require $page;
            exit();
        }
    }

    public function tryRenderOrDie($page) {
        $this->tryRender($page);

        error_log($_ENV['ERROR_MESSAGE']);
        die($_ENV['ERROR_MESSAGE']);
    }

    public function verifyOrDie() {
        if (!$this->session->verified()) {
            $this->tryRenderOrDie($this->home);
        }
    }
}

$app = new WorkoutApp();
$app->run();


?>
