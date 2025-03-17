<?php

namespace Product\Classes;

use PDO;
use Exception;

class User
{
    private $conn;
    private $table_name = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Register a new user
    public function registerUser($username, $email, $password)
    {
        try {
            // Validate input
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            }
            if (strlen($password) < 6) {
                throw new Exception("Password must be at least 6 characters.");
            }

            // Check if user already exists
            if ($this->getUserByEmail($email)) {
                throw new Exception("Email already registered.");
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $username = htmlspecialchars(strip_tags($username));
            $email = htmlspecialchars(strip_tags($email));
            $password = htmlspecialchars(strip_tags($hashed_password));

            // Bind parameters
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                return true;
            }

            // Log error information
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Error: " . $errorInfo[2]);
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }

    // Login a user
    public function loginUser($email, $password)
    {
        try {
            // Get user by email
            $user = $this->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Start session and set user data
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Update the updated_at column
                $updateQuery = "UPDATE " . $this->table_name . " SET updated_at = NOW() WHERE id = :id";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bindParam(':id', $user['id']);
                $updateStmt->execute();

                return true;
            }

            throw new Exception("Invalid email or password.");
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }

    // Get user by email
    public function getUserByEmail($email)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $email = htmlspecialchars(strip_tags($email));

            // Bind parameter
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $error) {
            return null;
        }
    }
}
