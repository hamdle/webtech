<?php

/*
 * Controllers/Dice.php: roll the dice
 *
 * This controller rolls dice for fun and for building exercises. You can't
 * name a class Die :(
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Controllers;

use Core\Http\Response;
use Core\Http\Code;

class Dice {
    public function d20()
    {
        return Response::send(
            Code::OK_200,
            [
                "die" => "d20",
                "result" => (rand() % 20) + 1,
            ]
        );
    }
}

