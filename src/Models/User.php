<?php

namespace ECommerce\Models;

use ECommerce\Models\ModelDBConnection;
use PDO;
use PDOException;
use PDOStatement;

final class User extends ModelDBConnection
{
    public function signupUser(string $fullName, string $email, string $password): PDOStatement|string
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


    public function loginUser(string $email, string $password): array|null|string
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

    public function logOutUser(object $session): bool
    {
        return $session->destroy();
    }
}
