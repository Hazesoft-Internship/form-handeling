<?php

namespace ayushtamang\FormHandeling\control;

class Validation
{
    public function validateString($value, $fieldName, $minLength = 2, $maxLength = 25)
    {
        if (strlen($value) < $minLength || strlen($value) > $maxLength) {
            throw new \Exception("$fieldName must be between $minLength and $maxLength characters.");   
        }
    }

    public function validateEmail($em)
    {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Invalid email format.");
        }
    }
}
?>