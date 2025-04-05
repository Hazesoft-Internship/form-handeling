<?php

namespace Hazesoft\Backend\Validations;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\Validation;
//use Hazesoft\Backend\Validations\Exception as Exception;

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
            throw new ValidationException($exception->getMessage());
        }
    }

    public function validateName(string $name, string $type): int
    {
        try {
            // type = first name, midlle name or last name
            $name = $this->sanitizeData($name);
            if (empty($name) && $type != "Middle Name") {
                throw new ValidationException("{$type} is required");
            }
            if (!preg_match("/^[a-zA-Z\s]+$/", $name) && $type != "Middle Name") {
                throw new ValidationException("{$type} can contain only letters and spaces.");
            }
            return 1; // No error
        } catch (Exception $exception) {
            throw new ValidationException($exception->getMessage());
        }
    }

    public function validateAddress(string $address): int
    {
        try {
            $address = $this->sanitizeData($address);
            if (empty($address)) {
                throw new ValidationException("Address is required.");
            }
            if (strlen($address) < 5) {
                throw new ValidationException("Address must be at least 5 characters long.");
            }
            return 1;
        } catch (Exception $exception) {
            throw new ValidationException($exception->getMessage());
        }
    }

    public function validateEmail(string $email): int
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

    public function validatePassword(string $password, string $confirmPassword): int
    {
        try {
            $password = $this->sanitizeData($password);
            $confirmPassword = $this->sanitizeData($confirmPassword);

            if (empty($password) || empty($confirmPassword)) {
                throw new ValidationException("Password and confirmation are required.");
            }
            if ($password !== $confirmPassword) {
                throw new ValidationException("Passwords do not match.");
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
