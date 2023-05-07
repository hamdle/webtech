<?php

namespace web;

class App
{
    const AUTH_REDIRECT = '/home';
    const PAGE_DIR = '/web/pages/';
    public static $obj = [];

    public static function getObject($lookup) {
        // TODO: need better cache implementation
        if ($lookup == 'session' && !array_key_exists('session', self::$obj)) {
            self::$obj['session'] = new \Models\Session();
        }
        return self::$obj[$lookup] ?? die("Object not found.");
    }

    public function render($page, $public = false)
    {
        if ($public) {
            return $this->_render($page);
        }

        if ($this->verifyUser()) {
            return $this->_render($page);
        }

        return $this->_render('404.php');
    }

    private function _render($template) {
        require_once dirname(__DIR__, 1).self::PAGE_DIR.$template;
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