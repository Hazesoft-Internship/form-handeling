<?php

abstract class Validation
{
    protected $patternName = "/^[a-zA-Z0-9]+$/";
    protected $patternEmail = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    protected $patternPassword = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";


    protected function sanitizeInput($inputArr)
    {
        return array_map(function ($userData) {
            $userData = trim($userData);
            return htmlspecialchars($userData);
        }, $inputArr);
    }

    abstract function validateUserInput($inputArr);
}

class ValidateSignup extends Validation
{
    public function validateUserInput($inputArr)
    {
        list($fullName, $email, $password) = $inputArr;

        if (!preg_match($this->patternName, $fullName) || !preg_match($this->patternEmail, $email)) {
            return "Invalid Input";
        }

        return $this->sanitizeInput($inputArr);
    }
}

class ValidateLogin extends Validation
{
    public function validateUserInput($inputArr)
    {
        list($email, $password) = $inputArr;

        if (!preg_match($this->patternEmail, $email)) {
            return "Invalid Input";
        }

        return $this->sanitizeInput($inputArr);
    }
}
