<?php

namespace web;

class App
{
    public static $obj = [];

    public static function getObject($lookup) {
        return self::$obj[$lookup] ?? null;
    }

    public function render($template) {
        if ($template == "Login") {
            require_once dirname(__DIR__,1) . '/web/pages/Login.php';
        }
        if ($template == "Home") {
            require_once dirname(__DIR__, 1) . '/web/pages/Home.php';
        }
        if ($template == "Go") {
            require_once dirname(__DIR__,1) . '/web/pages/Go.php';
        }
        if ($template == "Edit") {
            require_once dirname(__DIR__,1) . '/web/pages/Edit.php';
        }
        if ($template == "User") {
            require_once dirname(__DIR__,1) . '/web/pages/User.php';
        }
        if ($template == "Analyze") {
            require_once dirname(__DIR__,1) . '/web/pages/Analyze.php';
        }
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