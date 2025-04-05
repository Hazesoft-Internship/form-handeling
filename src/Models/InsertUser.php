<?php

namespace Hazesoft\Backend\Models;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Config\Connection;

class InsertUser
{
    private $conn;
    private $hashedPassword;
    public function __construct()
    {
        $connection = new Connection();
        $this->conn = $connection->connect();
    }
    public function insertUser($inputArray)
    {
        try {
            [$firstName, $middleName, $lastName, $address, $email, $password, $confirmPassword] = $inputArray; // destructuring of array

            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            // password hashing before inserting to db
            $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Preventing SQL injection
            $stmt = $this->conn->prepare("INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`, `password`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $firstName, $middleName, $lastName, $address, $email, $this->hashedPassword, $created_at, $updated_at);
            
            $result = $stmt->execute();

            // $sql = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`, `password`, `created_at`, `updated_at`) VALUES ('$firstName', '$middleName', '$lastName', '$address', '$email', '$this->hashedPassword', '$created_at', '$updated_at')";
            // $result = $this->conn->query($sql);

            $stmt->close();
            $this->conn->close();
            return $result;
        } catch (Exception $exception) {
            throw new Exception("Error inserting userdata into database " . $exception->getMessage());
        }
    }
    public function doesEmailExists($email)
    {
        try {
            $stmt = $this->conn->prepare("SELECT `email` FROM users WHERE `email`= ?");
            $stmt->bind_param("s", $email);

            $stmt->execute();
            $userData = $stmt->get_result();
        
            $row = $userData->fetch_assoc();
            
            // var_dump($row);
            $userEmail = $row["email"] ?? false;
            // var_dump($userEmail);

            if ($userEmail) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
