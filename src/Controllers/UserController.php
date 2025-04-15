<?php

declare(strict_types=1);

namespace src\Controllers;

use src\Models\User;
use src\Exceptions\ValidationException;
use src\Exceptions\DatabaseException;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login(): void
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->getUserByEmail($email);

            if (!$user || !password_verify($password, $user['password1'])) {
                throw new ValidationException("Invalid credentials!");
            }

            $_SESSION['user_id'] = $user['id'];
            header('Location: /public/index.php?controller=Product&action=index');
            exit;
        }

        require __DIR__ . '/../../views/user/login.php';
    }
}
