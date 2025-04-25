<?php

namespace Hazesoft\Backend\Services;

use Exception;
use PDO;
use PDOException;

class Connection
{
    private static ?Connection $instance = null;
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $charset = 'utf8mb4';
    private $connection;
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    private function __construct()
    {
        $this->host = $_ENV['HOST'];
        $this->username = $_ENV['USERNAME'];
        $this->password = $_ENV['PASSWORD'];
        $this->dbname = $_ENV['DBNAME'];

        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $this->options);
        } catch (PDOException $exception) {
            echo("Database connection failed: " . $exception->getMessage());
        }
    }

    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getConnection()
    {
        return self::getInstance()->connection;
    }
}
