<?php

namespace Hazesoft\Backend\Validations;

use Exception;
use Hazesoft\Backend\Validations\Validation;
use Hazesoft\Backend\Validations\ValidationException;

class LoginValidation extends Validation
{
    public function validateUserInput(array $inputArray): bool
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
            echo($exception->getMessage());
        }
    }

    public function validateEmail(string $email): int
    {
        try {
            $email = $this->sanitizeData($email);
            if (empty($email)) {
                echo("Email is required.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo("Invalid email format.");
            }
            return 1;
        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }

    public function validatePassword(string $password): int
    {
        try {
            $password = $this->sanitizeData($password);

            if (empty($password)) {
                echo("Password is required.");
            }
            if (strlen($password) < 8) {
                echo("Password must be at least 8 characters long.");
            }
            return 1;
        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }
}
