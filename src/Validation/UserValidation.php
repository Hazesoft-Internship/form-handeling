<?php

namespace App\Validation;

class UserValidation
{

    public static function signup(string $first_name, string $middle_name, string $last_name, string $email, string $address, string $password, string $confirm_password)
    {
        if (empty($first_name) || empty($last_name) || empty($email) || empty($address)) {
            die("All fields are required!");
        }
        if (! preg_match("/^[a-zA-Z-' ]*$/", $first_name)) {
            die("Not a valid first_name!");
        }
        if (! preg_match("/^[a-zA-Z-' ]*$/", $middle_name)) {
            die("Not a valid middle_name!");
        }
        if (! preg_match("/^[a-zA-Z-' ]*$/", $last_name)) {
            die("Not a valid last_name!");
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Not a valid email!");
        }
        if (! preg_match("/^[a-zA-Z0-9-' ]*$/", $address)) {
            die("Not a valid address!");
        }

        if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)) {
            die("the password does not meet the requirements!");
        }
        if ($password !== $confirm_password) {
            die("Password and confirm password do not match!");
        }

        return true;
    }

    public static function login(string $email, string $password)
    {
        if (empty($email) || empty($password)) {
            die("All fields are required!");
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Not a valid email!");
        }

        return true;
    }
}
