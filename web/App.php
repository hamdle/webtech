<?php

namespace web;

class App
{
    public $session;

    public function __construct() {
        $this->session = new \Models\Session();
    }

    public function render($uri)
    {
        $uri = str_replace('/','',$uri);

        $template = empty($uri)
            ? "Login.php"
            : ucwords(str_replace('/','',$uri)).".php";

        $this->session->tryLoadUser();
        include dirname(__DIR__, 1).$_ENV["WEB_PAGE_DIR"].$template;
    }
}