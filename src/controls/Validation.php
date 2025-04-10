<?php

namespace ayushtamang\FormHandeling\controls;

class Validation
{
    public function validateString($value, $fieldName, $minLength = 2, $maxLength = 25)
    {
        if (strlen($value) < $minLength || strlen($value) > $maxLength) {
            throw new \PDOException("$fieldName must be between $minLength and $maxLength characters.");   
        }
    }

    public function validateEmail($em)
    {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            throw new \PDOException("Invalid email format.");
        }
    }

    public function validateNumber($value, $fieldName, $minLength = 1, $maxLength = 11)
    {
        if (strlen($value) < $minLength || strlen($value) > $maxLength) {
            throw new \PDOException("$fieldName must be between $minLength and $maxLength characters.");   
        } elseif (!filter_var($value, FILTER_SANITIZE_NUMBER_INT)) {
            throw new \PDOException("$fieldName must be a number.");
        }
    }
}
?>