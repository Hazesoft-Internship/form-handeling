<?php

namespace ayushtamang\FormHandeling\database;

use PDO;

class Database {
    private static $instance = null;
    private $con;
    
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'haze';

    private function __construct() {
        try {
            $this->con = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed.";
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->con;
    }
}

?>
