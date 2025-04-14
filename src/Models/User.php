<?php

namespace Hazesoft\Formhandeling\Models;

use Hazesoft\Formhandeling\Services\Database;

use Exception;
use PDO;
use PDOException;

class User
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function register($fName, $mName, $lName, $address, $email, $password): bool
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $this->connection->prepare("
            INSERT INTO users (first_name, middle_name, last_name, address, email, password)
            VALUES (:first_name, :middle_name, :last_name, :address, :email, :password)
        ");

            $stmt->bindParam(':first_name', $fName);
            $stmt->bindParam(':middle_name', $mName);
            $stmt->bindParam(':last_name', $lName);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $passwordHash);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            //23000 means for duplication 
            if ($e->getCode() === '23000') {
                throw new Exception("Email already exists. Please use a different email.");
            } else {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }
    }


    public function login($email, $password)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, first_name, password FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }

            return false;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
}
