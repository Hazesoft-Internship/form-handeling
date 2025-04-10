<?php

namespace Hazesoft\Backend\Models;

use Exception;
use Hazesoft\Backend\Services\Connection;
use Hazesoft\Backend\Services\Session;

class User
{
    private $conn;
    private $hashedPassword;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    public function checkUser($inputArray): bool
    {
        try {
            [$email, $password] = $inputArray;

            $stmt = $this->conn->prepare("SELECT `id`, `first_name`, `email`, `password` FROM users WHERE `email`= :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $row = $stmt->fetch();

            if (!$row) {
                echo "User not found";
                return false;
            }

            $hashed_password = $row["password"];

            if (password_verify($password, $hashed_password)) {
                $session = Session::getInstance();
                $session->setSession("userId", (int)$row["id"]);
                $session->setSession("firstName", $row["first_name"]);
                $session->setSession("isLoggedIn", true);
                return true;
            } else {
                echo("Invalid password");
                return false;
            }
        } catch (Exception $exception) {
            echo("Invalid email or password " . $exception->getMessage());
            return false;
        }
    }

    public function insertUser($inputArray): bool
    {
        try {
            [$firstName, $middleName, $lastName, $address, $email, $password, $confirmPassword] = $inputArray; // destructuring of array

            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            // password hashing before inserting to db
            $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`, `password`, `created_at`, `updated_at`) 
         VALUES (:first_name, :middle_name, :last_name, :address, :email, :password, :created_at, :updated_at)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':middle_name', $middleName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $this->hashedPassword);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':updated_at', $updated_at);
            return $stmt->execute();

        } catch (Exception $exception) {
            echo("Error inserting userdata into database " . $exception->getMessage());
        }
    }

    public function doesEmailExists($email): bool
    {
        try {
            $stmt = $this->conn->prepare("SELECT `email` FROM users WHERE `email`= :email");
            $stmt->bindParam(':email', $email);

            $stmt->execute();

            $row = $stmt->fetch();

            $userEmail = $row["email"] ?? false;

            if ($userEmail) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }
}
