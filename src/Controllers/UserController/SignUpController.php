<?php

namespace Hazesoft\Backend\Controllers\UserController;

use Exception;
use Hazesoft\Backend\Models\User;
use Hazesoft\Backend\Validations\SignupValidation;
use Hazesoft\Backend\Validations\ValidationException;

class SignUpController
{
    private $signUpValidator;
    private $insertUser;

    public function __construct()
    {
        $this->signUpValidator = new SignupValidation();
        $this->insertUser = new User();
    }
    public function handleSignUpForm(): void
    {
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
                // Sanitization of inputArray
                $sanitizedInputArray = $this->signUpValidator->sanitizeArray($inputArray);

                // Check if user email exists
                $doesUserExists = $this->insertUser->doesEmailExists($sanitizedInputArray[4]); // index 4 is for email
                if ($doesUserExists) {
                    echo "User with this email already exists <br>";
                } else {

                    $isSignUpValid = $this->signUpValidator->validateUserInput($sanitizedInputArray);

                    if ($isSignUpValid) {
                        echo "Signup validation successful <br>";

                        // send data to db
                        $result = $this->insertUser->insertUser($inputArray);

                        if ($result) {
                            echo "User created successfully <br>";
                            echo '
                        <a href="/login">Go to login page</a>
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

    }
}
