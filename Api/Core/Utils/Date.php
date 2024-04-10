<?php

/*
 * Core/Utils/Date.php: Date helper functions
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Api\Core\Utils;

class Date
{
    // Format timestamp to datetime.
    public static function timestampToDatetime($timestamp)
    {
        return date("Y-m-d H:i:s", $timestamp);
    }
}
