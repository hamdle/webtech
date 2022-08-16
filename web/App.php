<?php

namespace web;

class App
{
    public static $obj = [];

    public static function getObject($lookup) {
        return self::$obj[$lookup] ?? null;
    }

    public function render($template) {
        $dir = dirname(__DIR__, 1)."/web/pages/";
        // Automatically generate pages, impact on performance
        // $templates = scandir($dir, 1);
        $templates = [
            "Analyze.php",
            "Edit.php",
            "Go.php",
            "Home.php",
            "Login.php",
            "User.php",
        ];
        $default = $templates[0];

        require_once $dir.(in_array($template, $templates) ? $template : $default);
    }

    private function verifyUser() {
        if (!array_key_exists('session', self::$obj)) {
            self::$obj['session'] = new \Models\Session();
        }
        return self::$obj['session']->verify();
    }

    public function verifySession($onSuccessRedirect = null) {
        // TODO: Verify $onSuccessRedirect is a template
        if (!is_null($onSuccessRedirect) && $this->verifyUser()) {
            header("Location: " . $_ENV['ORIGIN'] . $onSuccessRedirect);
            exit();
        }
        return $this;
    }
}