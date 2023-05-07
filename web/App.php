<?php

namespace web;

class App
{
    const PAGE_DIR = '/web/pages/';
    public static $obj = [];

    public static function getObject($lookup) {
        // TODO: need better cache implementation
        if ($lookup == 'session' && !array_key_exists('session', self::$obj)) {
            self::$obj['session'] = new \Models\Session();
        }
        return self::$obj[$lookup] ?? die("Object not found.");
    }

    public function render($template)
    {
        self::getObject('session')->loadUser();
        include dirname(__DIR__, 1).self::PAGE_DIR.$template;
    }
}