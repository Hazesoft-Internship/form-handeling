<?php

namespace ayushtamang\FormHandeling\traits;

trait DateTimeFormatter
{
    public function convertTime($time)
    {
        $time = explode(" ", $time);
        $formattedTime = date("d-M-Y", strtotime($time[0]));
        return $formattedTime;
    }
}
?>