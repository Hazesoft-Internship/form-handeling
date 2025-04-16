<?php

namespace ECommerce\Services;

use PDO;
use PDOException;

class DatabaseConnection
{
    const SERVER_NAME = "127.0.0.1";
    const USER_NAME = "root";
    const DATABASE = "ecommerce";
    const PASSWORD = "";

    private static $instance = null;
    private $pdoConnection;

    private  function  __construct()
    {
        try {
            $dsn = "mysql:host=" . self::SERVER_NAME . ";dbname=" . self::DATABASE;
            $this->pdoConnection = new PDO($dsn, self::USER_NAME, self::PASSWORD);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            return "Failed to connect to database";
        }
    }
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance->pdoConnection ?? "Failed to connect to database";
    }
}
