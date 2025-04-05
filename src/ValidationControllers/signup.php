<?php

namespace Hazesoft\Backend\ValidationControllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\SignupValidation;
use Hazesoft\Backend\Validations\ValidationException;
use Hazesoft\Backend\Models\InsertUser;

if ((isset($_SERVER['REQUEST_METHOD'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    try {
        // Capture form data
        $inputArray = [
            $_POST['firstName'] ?? '',
            $_POST['middleName'] ?? '',
            $_POST['lastName'] ?? '',
            $_POST['address'] ?? '',
            $_POST['email'] ?? '',
            $_POST['password'] ?? '',
            $_POST['confirmPassword'] ?? ''
        ];
    } catch (Exception $exception) {
        throw new ValidationException($exception->getMessage());
    }

    try {
        // Initialize validation
        $signUpValidator = new SignupValidation();

        // Initialize InsertUser model
        $insertUserObject = new InsertUser();

        // Sanitization of inputArray
        $sanitizedInputArray = $signUpValidator->sanitizeArray($inputArray);

        // Check if user email exists
        $doesUserExists = $insertUserObject->doesEmailExists($sanitizedInputArray[4]); // index 4 is for email
        if ($doesUserExists) {
            echo "User with this email already exists <br>";
        } else {

            $isSignUpValid = $signUpValidator->validateUserInput($sanitizedInputArray);

            if ($isSignUpValid) {
                echo "Signup validation successful <br>";

                // send data to db
                $result = $insertUserObject->insertUser($inputArray);

                if ($result) {
                    echo "User created successfully <br>";
                    echo '
                        <a href="../Views/login.html">Go to login page</a>
                    ';
                } else {
                    echo "User creation failed <br>";
                }
            } else {
                throw new ValidationException("Signup validation error");
            }
        }
    } catch (Exception $exception) {
        throw new ValidationException("Signup validation error: " . $exception->getMessage());
    }
}
