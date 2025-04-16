<?php

namespace ECommerce\Utils\Validation;

require_once 'Validation.php';
require_once 'ValidationException.php';

use ECommerce\Utils\Validation\ValidationException;
use ECommerce\Utils\Validation\Validation;

class ValidateSignup extends Validation
{
    public function validateUserInput(array $inputArr): array
    {
        try {
            list($fullName, $email, $password) = $inputArr;

            if (!preg_match($this->patternName, $fullName)) {
                throw new ValidationException("Invalid full name format.");
            }

            if (!preg_match($this->patternEmail, $email)) {
                throw new ValidationException("Invalid email format.");
            }

            if (!preg_match($this->patternPassword, $password)) {
                throw new ValidationException("Password must be at least 8 characters long and include at least one letter and one number.");
            }

            return $this->sanitizeInput($inputArr);
        } catch (ValidationException $e) {
            return ["error" => $e->errorMessage()];
        }
    }
}
