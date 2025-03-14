<?php

class Validate
{


    public static function validate(string $first_name, string $middle_name, string $last_name, string $email, string $address)
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

        return true;
    }
}
