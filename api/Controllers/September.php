<?php

/*
 * Controllers/September.php: count down the time
 *
 * Count down the time until my wedding party in September.
 *
 * Copyright (C) 2022 Eric Marty
 */

namespace Controllers;

use Core\Http\Response;
use Core\Http\Code;

class September {
    public function countdown()
    {
        $dateToday = "now";
        $dateSept = "2022-09-09 12:00:00";
        $timestampToday = strtotime($dateToday);
        $timestampSept = strtotime($dateSept);
        $days = round(abs($timestampSept - $timestampToday)/(60*60*24), 2);
        $months = round((abs($timestampSept - $timestampToday)/(60*60*24)/30), 2);

        return Response::send(
            Code::OK_200,
            [
                "now" => date('M-d-y', $timestampToday),
                "september" => date('M-d-y', $timestampSept),
                "days" => $days,
                "months" => $months,
            ]
        );
    }
}

