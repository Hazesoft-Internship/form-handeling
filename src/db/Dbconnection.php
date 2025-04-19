<?php

namespace Lattefront\FormHandeling\Db;

use PDO;
use PDOException;

class DbConnection
{
    private PDO $conn;

    public function __construct(
        private string $servername = "localhost",
        private string $username = "lattefront",
        private string $password = "lattefront",
        private string $dbname = "hazesoft"
    ) {
        // $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
      try {
          $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
          echo("Connection failed: " . $e->getMessage());
      }
    }
    public function getConnection(): PDO //  method to access the connection
    {
        return $this->conn;
    }
}
