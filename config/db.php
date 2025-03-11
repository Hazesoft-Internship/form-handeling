<?php

namespace formhandeling\config;

use mysqli;
use Exception;

require_once __DIR__ . "/session.php";


error_reporting(E_ALL);
ini_set('display_errors', 1);


class Database
{
    private static $instance = null;
    private $connection;

    private function __construct(
        private $servername = "localhost",
        private $username = "root",
        private $password = "Prakash@123$",
        private $dbname = "mydb"
    ) {
        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->connection->connect_error) {
            throw new Exception("Unable to connect to the database: " . $this->connection->connect_error);
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
