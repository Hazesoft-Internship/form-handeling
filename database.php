<?php

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "123";
    private $dbname = "data";
    private $conn;
    private static $instance;


    private function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

  
    public function getConnection() {
        return $this->conn;
    }
}
?>
