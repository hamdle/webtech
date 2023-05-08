<?php

require_once dirname(__DIR__,1) . "/autoload.php";

class WorkoutApp {
    public function run() {
        $session = new \Models\Session();
        $session->tryLoadUser();

        $uri = $_SERVER["REQUEST_URI"];     // eg "/home", "/home/page/"
        $file = str_replace('/','',$uri);
        $file = empty($file)
            ? $_ENV["HOME_PAGE"]
            : ucwords(str_replace('/','',$file)).".php";
        $file = dirname(__DIR__,1).$_ENV["WEB_PAGE_DIR"].$file;

        try {
            if (file_exists($file)) {
                include $file;
                exit();
            }
            $this->tryLoadHomePage();
        } catch (\Exception $e) {
            error_log($e->getFile().PHP_EOL.$e->getMessage());
            $this->tryLoadHomePage();
        }
    }
    private function tryLoadHomePage() {
        $file = dirname(__DIR__,1).$_ENV["WEB_PAGE_DIR"].$_ENV["HOME_PAGE"];

        if (file_exists($file)) {
            error_log($file." fail failed to load. Loading home page instead ".$_ENV["HOME_PAGE"]);
            include $file;
            exit();
        }
        // on fail
        error_log("No templates available.");
        exit();
    }
}

$app = new WorkoutApp();
$app->run();


?>
