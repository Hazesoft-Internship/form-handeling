<?php

declare(strict_types=1);

namespace Classes;

use PDO;
use PDOException;

// Connecting Database
class DB
{
    private PDO $conn;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db = 'form';
        $user = 'root';  
        $pass = 'admin@Suy31';       

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
