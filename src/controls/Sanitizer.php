<?php

namespace ayushtamang\FormHandeling\controls;
class Sanitizer
{
    public static function sanitizeString($inputText): string 
    {
        $inputText = str_replace(" ", "", $inputText);
        $inputText = strtolower($inputText);
        $inputText = ucfirst($inputText);
        return $inputText;
    }

    public static function sanitizeEmail($inputText): string 
    {   
        $inputText = str_replace(" ", "", $inputText);
        $inputText = strtolower($inputText);
        return $inputText;
    }

    public static function sanitizePassword($inputText) 
    {
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    public static function sanitizeInteger($inputText): int
    {
        $inputText = str_replace(" ", "", $inputText);
        $inputText = (int)$inputText;
        return $inputText;
    }
}
?>