<?php

namespace Hazesoft\Formhandeling\Services;

trait DateFormatter
{
    public static function convertDateTime($time): string
    {
        $time = explode(" ", $time);

        $formattedTime = date("d-M-Y", strtotime($time[0]));

        return $formattedTime;
    }
}
