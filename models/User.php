<?php

namespace HazeSoft\Backend\formHandeling\models;

require_once '../config/dbConnection.php';

use HazeSoft\Backend\formHandeling\config\DatabaseConnection;

class User
{
    private $dbConnection;
    private $database;
    
    public function __construct()
    {
        $this->database = new DatabaseConnection();
        $this->dbConnection = $this->database->connectDB();
    }

    public function registerUser($fullName, $email, $password): string
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $registerUserQuery = "INSERT INTO users (fullName, email, password) VALUES ('$fullName','$email','$hashedPassword')";

        $registerUser = mysqli_query($this->dbConnection, $registerUserQuery);
        if ($registerUser) {

            return "User registered successfully";
        } else {
            return "Failed to register user";
        }
    }

    public function loginUser($email, $password)
    {
        $userDataQuery = "SELECT * FROM users WHERE email = '$email'";
        $userData = mysqli_query($this->dbConnection, $userDataQuery);

        if (mysqli_num_rows($userData) > 0) {
            $user = mysqli_fetch_assoc($userData);
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['LoggedIn'] = true;
                $_SESSION['userID'] = $user['id'];
                header("Location: /product-store");
            } else {
                echo "Invalid password";
            }
        } else {
            echo "User does not exist";
        }
    }

    public function logOutUser(): void
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /");
        exit();
    }
}
