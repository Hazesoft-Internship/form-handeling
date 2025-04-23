<?php

namespace ECommerce\Controllers\UserController;

use ECommerce\Models\User;
use ECommerce\Utils\Validation\ValidateSignup;

class SignUpController
{
    private $signupValidation;
    private $user;

    public function __construct()
    {
        $this->user = new User();
        $this->signupValidation = new ValidateSignup();
    }

    public function handleSignUpForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['register'])) {
            $email = $_POST['email'];
            $fullName = $_POST['fullName'];
            $password = $_POST['password'];

            $santizedUserInput = $this->signupValidation->validateUserInput([$fullName, $email, $password]);
            if (isset($santizedUserInput["error"])) {
                echo $santizedUserInput['error'];
            }

            $signupResult = $this->user->signupUser($santizedUserInput[0], $santizedUserInput[1], $santizedUserInput[2]);
            if ($signupResult) {
                echo "User signup Successfully";
                header("Location: /login");
                exit();
            }
            echo "Failed to signup user";
        }
    }

    public function getSignUpPage()
    {
        return require_once __DIR__ . '/../../Views/signup.html';
    }
}
