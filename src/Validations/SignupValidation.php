<?php

namespace Hazesoft\Backend\Validations;

use Exception;
use Hazesoft\Backend\Validations\Validation;

class SignupValidation extends Validation
{
    public function validateUserInput(array $inputArray): bool
    {
        try {
            [$firstName, $middleName, $lastName, $address, $email, $password, $confirmPassword] = $inputArray; // destructuring of array
            // validation status
            $isValidationOk = 0;

            $isValidationOk += $this->validateName($firstName, "First Name");
            $isValidationOk += $this->validateName($middleName, "Middle Name");
            $isValidationOk += $this->validateName($lastName, "Last Name");
            $isValidationOk += $this->validateAddress($address);
            $isValidationOk += $this->validateEmail($email);
            $isValidationOk += $this->validatePassword($password, $confirmPassword);

            if ($isValidationOk == 6) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            echo($exception->getMessage());
            return false;
        }
    }

    public function validateName(string $name, string $type): int
    {
        try {
            // type = first name, midlle name or last name
            $name = $this->sanitizeData($name);
            if (empty($name) && $type != "Middle Name") {
                echo("{$type} is required");
                return 0;
            }
            if (!preg_match("/^[a-zA-Z\s]+$/", $name) && $type != "Middle Name") {
                echo("{$type} can contain only letters and spaces.");
                return 0;
            }
            return 1; // No error
        } catch (Exception $exception) {
            echo($exception->getMessage());
            return 0;
        }
    }

    public function validateAddress(string $address): int
    {
        try {
            $address = $this->sanitizeData($address);
            if (empty($address)) {
                echo("Address is required.");
                return 0;
            }
            if (strlen($address) < 5) {
                echo("Address must be at least 5 characters long.");
                return 0;
            }
            return 1;
        } catch (Exception $exception) {
            echo($exception->getMessage());
            return 0;
        }
    }

    public function validateEmail(string $email): int
    {
        try {
            $email = $this->sanitizeData($email);
            if (empty($email)) {
                echo("Email is required.");
                return 0;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo("Invalid email format.");
                return 0;
            }
            return 1;
        } catch (Exception $exception) {
            echo($exception->getMessage());
            return 0;
        }
    }

    public function validatePassword(string $password, string $confirmPassword): int
    {
        try {
            $password = $this->sanitizeData($password);
            $confirmPassword = $this->sanitizeData($confirmPassword);

            if (empty($password) || empty($confirmPassword)) {
                echo("Password and confirmation are required.");
                return 0;
            }
            if ($password !== $confirmPassword) {
                echo("Passwords do not match.");
                return 0;
            }
            if (strlen($password) < 8) {
                echo("Password must be at least 8 characters long.");
                return 0;
            }
            return 1;
        } catch (Exception $exception) {
            echo($exception->getMessage());
            return 0;
        }
    }
}
