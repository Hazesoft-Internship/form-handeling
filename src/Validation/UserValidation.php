<?php

namespace Hazesoft\Formhandeling\Validation;

use Hazesoft\Formhandeling\Exception\ValidationException;

use Hazesoft\Formhandeling\Validation\Validation;

class UserValidation extends Validation
{

    public function validateEmail($data)
    {
        if (empty($data)) {
            throw new ValidationException("Field is required", 204);
        }
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Incorrect Email Format", 422);
        }
        return $data;
    }

    public function validatePassword($data)
    {
        if (empty($data)) {
            throw new ValidationException("Field is required", 204);
        }
        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=]).{8,}$/", $data)) {
            throw new ValidationException(
                "Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character.",
                422
            );
        }
        return $this->test_input($data);
    }

    public function validateForm($data)
    {
        return [
            'fname' => $this->validateString($data['fname']),
            'mname' => $this->validateString($data['mname']),
            'lname' => $this->validateString($data['lname']),
            'email' => $this->validateEmail($data['email']),
            'address' => $this->validateString($data['address']),
            'password' => $this->validatePassword($data['password']),
        ];
    }
}
