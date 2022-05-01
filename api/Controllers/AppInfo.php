<?php

/*
 * Controllers/AppInfo.php: get information about the app
 *
 * The purpose of this controller is to provide information about the Api,
 * typically these requests are public and available to anyone willing to ask.
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Controllers;

use Core\Http\Response;
use Core\Http\Code;

class AppInfo {
    public function version()
    {
        return Response::send
        (
            Code::OK_200,
            [
                "version" => $_ENV["VERSION"],
            ]
        );
    }

    public function teapot()
    {
        return Response::send
        (
            Code::IM_A_TEAPOT_418,
            [
                "message" => "418 I'm a teapot",
            ]
        );
    }
}
