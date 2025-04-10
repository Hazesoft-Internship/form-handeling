<?php

namespace Hazesoft\Formhandeling\Controllers;

use Hazesoft\Formhandeling\Services\Session;
use Hazesoft\Formhandeling\Services\View;
use Hazesoft\Formhandeling\Models\User;
use Exception;
use Hazesoft\Formhandeling\Validation\UserValidation;
use Hazesoft\Formhandeling\Exception\ValidationException;

$session = Session::getInstance();

$session->start();

class AuthController
{

    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function register(): void
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $validation = new UserValidation();

                try {
                    $validateData = $validation->validateForm($_POST);

                    $fName = $validateData['fname'];
                    $mName = $validateData['mname'];
                    $lName = $validateData['lname'];
                    $email = $validateData['email'];
                    $address = $validateData['address'];
                    $password = $validateData['password'];

                    try {
                        if ($this->user->register($fName, $mName, $lName, $address, $email, $password)) {
                            header("Location: /login");
                            exit();
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } catch (ValidationException $validationException) {
                    $errors = $validationException->getMessage();
                    View::render('register_form', ['errors' => $errors, 'postData' => $_POST]);
                }
            } else {
                View::render('register_form');
            }
        } catch (Exception $e) {
            echo "Unexpected error: " . $e->getMessage();
        }
    }

    public function login(): void
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $email = $_POST["email"];
                $password = $_POST["password"];

                $user = $this->user->login($email, $password);

                if ($user) {
                    $_SESSION['id'] = $user['id'];
                    header("Location: /products");
                    exit();
                } else {
                    throw new ValidationException("Invalid email or password.");
                }
            } else {
                View::render("login_form");
            }
        } catch (ValidationException $validationException) {
            View::render("login_form", [
                'error' => $validationException->getMessage(),
                'email' => $_POST['email'] ?? ''
            ]);
        }
    }

    public function handleLogout()
    {
        $session = Session::getInstance();
        $session->start();

        session_unset();
        session_destroy();

        header("Location: /");
        exit();
    }
}
