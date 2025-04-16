<?php

namespace ECommerce\Models;

use ECommerce\Services\DatabaseConnection;
use PDO;
use PDOException;

final class User
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = DatabaseConnection::getInstance();
    }

    public function signupUser($fullName, $email, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $registerUserQuery = "INSERT INTO users (fullName, email, password) VALUES (:fullName, :email, :password)";
            $statement = $this->dbConnection->prepare($registerUserQuery);
            $statement->bindParam(':fullName', $fullName);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':password', $hashedPassword);

            return $statement->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function loginUser($email, $password)
    {
        try {
            $userDataQuery = "SELECT * FROM users WHERE email = :email";
            $statement = $this->dbConnection->prepare($userDataQuery);
            $statement->bindParam(':email', $email);
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }

            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function logOutUser($session)
    {
        return $session->destroy();
    }
}
