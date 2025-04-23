<?php

namespace ECommerce\Controllers\UserController;

use ECommerce\Models\User;
use ECommerce\Utils\Validation\ValidateLogin;
use ECommerce\Services\Session;

class LogInController
{
    private $user;
    private $loginValidation;

    public function __construct()
    {
        $this->user = new User();
        $this->loginValidation = new ValidateLogin();
    }

    public function handleLoginForm()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sanitizedUserInput = $this->loginValidation->validateUserInput([$email, $password]);
            if (isset($sanitizedUserInput["error"])) {
                $errorMessage = $sanitizedUserInput['error'];
                echo $errorMessage;
            } else {
                $loginResult = $this->user->loginUser($sanitizedUserInput[0], $sanitizedUserInput[1]);

                if ($loginResult) {
                    $session = Session::getInstance();
                    $session->set("LoggedIn", true);
                    $session->set("userID", $loginResult['id']);
                    header("Location: /allproducts");
                    exit();
                } else {
                    echo "Invalid email or password.";
                }
            }
        }
    }

    public function getLoginPage()
    {
        return require_once __DIR__ . '/../../Views/login.html';
    }
}
