<?php

namespace ECommerce\Utils\Validation;

use ECommerce\Utils\Validation\Validation;
use ECommerce\Utils\Validation\ValidationException;

class ValidateLogin extends Validation
{
    public function validateUserInput(array $inputArr): array
    {
        try {
            list($email, $password) = $inputArr;

            if (!preg_match($this->patternEmail, $email)) {
                throw new ValidationException("Invalid email format.");
            }

            return $this->sanitizeInput($inputArr);
        } catch (ValidationException $e) {
            return ["error" => $e->errorMessage()];
        }
    }
}
