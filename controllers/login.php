<?php

namespace formhandeling\controllers;

use formhandeling\models\User;

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/users.php';


class Login
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function handleRequest(): void
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = $this->user->login($email, $password);
            if ($user) {
                $_SESSION['id'] = $user['id'];

                header("Location: ../views/products.php");
                exit();
            } else {
                echo "Invalid email or password";
            }
        }
    }
}

$login = new Login();
$login->handleRequest();
