<?php

namespace Hazesoft\Formhandeling\Services;

use PDO;
use PDOException;
use Exception;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct(
        private string $servername = "localhost",
        private string $username = "root",
        private string $password = "Prakash@123$",
        private string $dbname = "mydb"
    ) {
        $data = "mysql:host={$this->servername};dbname={$this->dbname};charset=utf8mb4";

        try {
            $this->connection = new PDO($data, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Unable to connect to the database: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
