<?php

namespace App\traits;

trait DatetimeFormatter
{
    public static function convertDateTime($time)
    {
        $time = explode(" ", $time);
        $formattedTime = date("d-M-Y", strtotime($time[0]));
        return $formattedTime;
    }
}
