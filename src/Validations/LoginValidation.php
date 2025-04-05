<?php

namespace Hazesoft\Backend\Validations;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\Validation;
use Hazesoft\Backend\Validations\ValidationException;

class LoginValidation extends Validation
{
    public function validateUserInput(array $inputArray)
    {
        try {
            [$email, $password] = $inputArray;

            // validation status
            $isValidationOk = 0;

            $isValidationOk += $this->validateEmail($email);
            $isValidationOk += $this->validatePassword($password);

            if ($isValidationOk == 2) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            throw new ValidationException($exception->getMessage());
        }
    }

    public function validateEmail(string $email)
    {
        try {
            $email = $this->sanitizeData($email);
            if (empty($email)) {
                throw new ValidationException("Email is required.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new ValidationException("Invalid email format.");
            }
            return 1;
        } catch (Exception $exception) {
            throw new ValidationException($exception->getMessage());
        }
    }

    public function validatePassword(string $password)
    {
        try {
            $password = $this->sanitizeData($password);

            if (empty($password)) {
                throw new ValidationException("Password is required.");
            }
            if (strlen($password) < 8) {
                throw new ValidationException("Password must be at least 8 characters long.");
            }
            return 1;
        } catch (Exception $exception) {
            throw new ValidationException($exception->getMessage());
        }
    }
}
