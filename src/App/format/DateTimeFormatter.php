<?php

namespace App\format;

use App\traits\DatetimeFormatter as TraitsDatetimeFormatter;

class DateTimeFormatter
{
    use TraitsDatetimeFormatter;

    public static function formatDateTime($time)
    {
        $formattedDate = self::convertDateTime($time);
        return $formattedDate;
    }
}
