<?php

namespace Lattefront\FormHandeling\Db;

use PDO;
use PDOException;

class DbConnection
{
    private PDO $conn;
    
    public function __construct(
        public string $servername = '',
        private string $username = '',
        private string $password = '',
        private string $dbname = '',
        
    ) {
        $this->servername = $servername ?: $_ENV['DATABASE_URL'];
        $this->username = $username ?: $_ENV['DATABASE_USERNAME'];
        $this->password = $password ?: $_ENV['DATABASE_PASSWORD'];
        $this->dbname = $dbname ?: $_ENV['DATABASE_NAME'];

        // $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        try {
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo ("Connection failed: " . $e->getMessage());
        }
    }
    public function getConnection(): PDO //  method to access the connection
    {
        return $this->conn;
    }
}
