<?php

declare(strict_types=1);

namespace Classes;

use PDO;

// Inserting User info into the database
class User
{
    private PDO $conn;

    public function __construct(DB $db)
    {
        $this->conn = $db->getConnection();
    }

    public function insertUser(array $userData): bool
    {
        $sql = "INSERT INTO users (first_name, middle_name, last_name, address, email) 
                VALUES (:first_name, :middle_name, :last_name, :address, :email)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($userData);
    }
}
