<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once "User.php";
    require_once "Validation.php";

class Database{
    private $connection;
     public function __construct(
        private $serverName = 'localhost',
        private $userName = 'root',
        private $password = '',
        private $dbName = 'mysql1'
     )

      {
        $this->connection = new mysqli ($this->serverName, $this->userName, $this->password, $this->dbName);
        if ($this->connection->connect_error) {
            echo "connection error";
        }
        else {
            echo "connected sucessfully";
        }
      }

      public function getConnection(): mysqli
      {
          return $this->connection;
      }
}

$db = new Database();
$conn = $db->getConnection();

   