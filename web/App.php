<?php

namespace web;

class App
{
    public static $obj = [];

    public static function getObject($lookup) {
        return self::$obj[$lookup] ?? null;
    }

    public function render($template) {
        $templates = [
            "Login",
            "Home",
            "Go",
            "Edit",
            "User",
            "Analyze"
        ];
        $default = $templates[0];

        require_once dirname(__DIR__, 1).
            "/web/pages/".
            (in_array($template, $templates) ? $template : $default).".php";
    }

    public function authenticate() {
        if (!array_key_exists('session', self::$obj)) {
            self::$obj['session'] = new \Models\Session();
        }
        if (!self::$obj['session']->verify()) {
            header("Location: " . $_ENV['ORIGIN']);
            exit();
        }
        return $this;
    }

    public function redirectAuthenticated($path) {
        if (!array_key_exists('session', self::$obj)) {
            self::$obj['session'] = new \Models\Session();
        }
        if (self::$obj['session']->verify()) {
            header("Location: " . $_ENV['ORIGIN'] . $path);
            exit();
        }
        return $this;
    }
}