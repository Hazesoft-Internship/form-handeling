<?php
namespace database;
use mysqli;
class DbConnection
{
    private mysqli $conn;

    public function __construct(
        private string $servername = "localhost",
        private string $username = "lattefront",
        private string $password = "lattefront",
        private string $dbname = "hazesoft"
    ) {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public function getConnection(): mysqli //  method to access the connection
    {
        return $this->conn;
    }
}
