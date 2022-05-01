<?php

namespace web;

class App
{
    public function render($template) {
        if ($template == "Login") {
            require_once dirname(__DIR__,1) . '/web/pages/Login.php';
        }
        if ($template == "Home") {
            require_once dirname(__DIR__,1) . '/web/pages/Home.php';
        }
    }

    public function authenticate() {
        $session = new \Models\Session();
        if (!$session->verify()) {
            header("Location: " . $_ENV['ORIGIN']);
            exit();
        }
        return $this;
    }
}