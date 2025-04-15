<?php

namespace Hazesoft\Backend\Services;

use Exception;
use PDO;
use PDOException;

class Connection
{
    private static ?Connection $instance = null;
    private $host = '127.0.0.1';
    private $username = 'root';
    private $password = '';
    private $dbname = 'mydb';
    private $charset = 'utf8mb4';
    private $connection;
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    private function __construct()
    {
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
