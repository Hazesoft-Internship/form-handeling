<?php

namespace formhandeling\controllers;

use formhandeling\models\User;
use Exception;

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/users.php';


class UserController
{
    private $user;
    private $errors = [];


    public function __construct()
    {
        $this->user = new User();
    }

    private function test_input($data): string
    {
        return htmlspecialchars(trim($data));
    }

    private function validateInput($data, $fieldName, $pattern = ""): string
    {
        if (empty($data)) {
            $this->errors[$fieldName] = "$fieldName is required";
            return "";
        }
        $data = $this->test_input($data);
        if ($pattern && !preg_match($pattern, $data)) {
            $this->errors[$fieldName] = "Invalid $fieldName format";
            return "";
        }
        return $data;
    }

    public function handleRequest(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fName = $this->validateInput($_POST["fname"] ?? "", "First name", "/^[a-zA-Z-' ]*$/");
            $mName = $this->validateInput($_POST["mname"] ?? "", "Middle name", "/^[a-zA-Z-' ]*$/");
            $lName = $this->validateInput($_POST["lname"] ?? "", "Last name", "/^[a-zA-Z-' ]*$/");
            $email = $this->validateInput($_POST["email"] ?? "", "Email", "/^[\w\.-]+@[\w\.-]+\.\w+$/");
            $address = $this->validateInput($_POST["address"] ?? "", "Address");
            $password = $this->validateInput($_POST["password"] ?? "", "Password");
            $confirm_password = $this->validateInput($_POST["password_confirmation"] ?? "", "Confirm Password");

            if ($password !== $confirm_password) {
                $this->errors[$password] = "Passwords do not match";
            }

            if (empty($this->errors)) {
                try {
                    if ($this->user->register($fName, $mName, $lName, $address, $email, $password)) {
                        header("Location: ../views/login_form.php");
                        exit();
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                foreach ($this->errors as $error) {
                    echo $error . "<br>";
                }
            }
        }
    }
}

$controller = new UserController();
$controller->handleRequest();
