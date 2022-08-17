<?php

namespace web;

class App
{
    public static $obj = [];

    public static function getObject($lookup) {
        // TODO: need better cache implementation
        if ($lookup == 'session' && !array_key_exists('session', self::$obj)) {
            self::$obj['session'] = new \Models\Session();
        }
        return self::$obj[$lookup] ?? die("Object not found.");
    }

    public function render($template) {
        $dir = dirname(__DIR__, 1)."/web/pages/";
        // Automatically generate pages, impact on performance
        // $templates = scandir($dir, 1);
        // TODO: pages should be authenticated automatically by the App
        // $templates = [["Login.php", "public"], ["Edit.php", "auth"]]
        $templates = [
            "Stats.php",
            "Edit.php",
            "Go.php",
            "Home.php",
            "Login.php",
            "User.php",
        ];
        $default = $templates[0];

        require_once $dir.(in_array($template, $templates) ? $template : $default);
    }

    public function verifyUser() {
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