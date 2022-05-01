<?php

namespace web;

class App
{
    public function render($template) {
        if ($template == "Login") {
            require_once __DIR__ . '/../web/pages/Login.php';
        }
        if ($template == "Home") {
            require_once __DIR__ . '/../web/pages/Home.php';
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