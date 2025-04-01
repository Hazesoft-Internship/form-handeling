<?php

namespace App\validate;

use CustomException;

error_reporting(E_ALL);
ini_set('display_errors', 1);
class Validation
{
    public $errors = [];
    public function validator(array $details)
    {
        if (empty($details["firstName"])) {
            $this->errors["firstname"] = "firstName is required";
        } elseif (strlen($details["firstName"]) < 2) {
            $this->errors["firstName"] = "firstname must be more than 2 length";
        }

        if (empty($details["lastName"])) {
            $this->errors["lastName"] = "lastName is required";
        } elseif (strlen($details["lastName"]) < 2) {
            $this->errors["lastName"] = "lastName must be more than 2 length";
        }

        if (empty($details["email"])) {
            $this->errors["email"] = "email is required";
        }

        if (!(empty($this->errors))) {
            throw new CustomException($this->errors);
        }
    }
}
