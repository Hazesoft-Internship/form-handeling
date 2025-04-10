<?php

namespace Hazesoft\Backend\Controllers\UserController;

use Exception;
use Hazesoft\Backend\Models\User;
use Hazesoft\Backend\Services\Session;
use Hazesoft\Backend\Validations\LoginValidation;
use Hazesoft\Backend\Validations\ValidationException;

class LogInController
{
    public function handleLoginForm()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            try {
                // Capture form data
                $inputArray = [
                    $_POST['email'] ?? '',
                    $_POST['password'] ?? ''
                ];
            } catch (Exception $exception) {
                throw new ValidationException($exception->getMessage());
            }

            try {
                // Initialize validation
                $loginValidator = new LoginValidation();

                // Sanitization of inputArray
                $sanitizedInputArray = $loginValidator->sanitizeArray($inputArray);
                $isLoginValid = $loginValidator->validateUserInput($sanitizedInputArray);

                if ($isLoginValid) {
                    echo ("Login validation successful <br>");

                    // send data to db
                    $checkUserObject = new User();
                    $result = $checkUserObject->checkUser($inputArray);

                    if ($result) {
                        echo "Login successful <br>";
                        echo '
                        <a href="/products">Go to Products page</a>
                    ';
                    } else {
                        echo "Login failed";
                    }
                } else {
                    echo "Validation error";
                    throw new ValidationException("Signin validation error");
                }
            } catch (Exception $exception) {
                throw new ValidationException("Signin validation error: " . $exception->getMessage());
            }
        }

    }

    public function handleLogout(): void
    {
        $session = Session::getInstance();
        $session->destroySession();
        header("Location: /");
    }

    public function getLoginPage()
    {
        return require_once(__DIR__ . '/../../Views/login-form.html');
    }

    public function getSignUpPage()
    {
        return require_once(__DIR__ . '/../../Views/signup-form.html');
    }

}
