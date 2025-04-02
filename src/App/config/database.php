<?php

namespace App\config;

class Database
{
    private $conn;
    private static $server = "localhost";
    private static $username = "phpmyadmin";
    private static $password = "Smith@123";
    private static $dbName = "hazesoft";
    private static $instance = null;
    private function __construct()
    {
        $this->conn = new \mysqli(self::$server, self::$username, self::$password, self::$dbName);
        if ($this->conn->connect_error) {
            die("couldnot connect to database" . $this->conn->connect_error);
        } else {
            // echo "connected to database";
            return $this->conn;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
