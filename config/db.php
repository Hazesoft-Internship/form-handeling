<?php

namespace Product\Config;

use PDO;
use PDOException;

class Database
{
    private $host = 'localhost';
    private $db_name = 'user_database';
    private $username = 'weave';
    private $password = 'weave@1';
    public $conn;

    public function getConnection()
    {
        $this->conn = null; //Ensures a fresh connection every time

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
