<?php

namespace App\database;

use PDO;

class Database
{
    private $conn;
    private static $instance = null;
    private function __construct()
    {
        try {

            $this->conn = new PDO('mysql:host=' . $_ENV["DB_HOST"] . ';dbname=' . $_ENV["DB_DATABASE"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);
        } catch (\PDOException $e) {
            throw new \PDOException("not connected to database" . $e->getMessage(), $e->getCode());
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
