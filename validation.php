<?php

//CODE VALIDATION 

class Validation
{

    public function validateName($firstName, $middleName, $lastName)
    {
        if (empty($firstName)) {
            echo "First name is required";
            die();
        } else if (!preg_match("/^[a-zA-Z-']+$/", $firstName)) {
            echo "Only letters are allowed in first name!";
            die();
        }

        if (!empty($middleName)) {
            if (!preg_match("/^[a-zA-Z-']+$/", $middleName)) {
                echo "Only letters are allowed in middle name!";
                die();
            }
        }

        if (empty($lastName)) {
            echo "Last name is required";
            die();
        } else if (!preg_match("/^[a-zA-Z-']+$/", $lastName)) {
            echo "Only letters are allowed in last name!";
            die();
        }
    }
    public function validateAddress($address)
    {
        if (empty($address)) {
            echo "Address is required";
            die();
        } else  if (!preg_match("/^[a-zA-Z0-9\s,'-]+$/", $address)) {
            echo "Only letters, numbers, white spaces, commas, apostrophes and hyphens are allowed
            in address!";
            die();
        }
    }

    public function validateEmail($email)
    {
        if (empty($email)) {
            echo "Email is required";
            die();
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format!";
            die();
        }
    }
}



