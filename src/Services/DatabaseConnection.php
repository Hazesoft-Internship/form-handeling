<?php

namespace ECommerce\Services;

use PDO;
use PDOException;

class DatabaseConnection
{
    private static $configDB;
    private static $instance = null;
    private $pdoConnection;

    private  function  __construct()
    {
        self::$configDB = require_once __DIR__ . '/../Utils/envConfig.php';
        try {
            $dsn = "mysql:host=" . self::$configDB['SERVER'] . ";dbname=" . self::$configDB['DATABASE'];
            $this->pdoConnection = new PDO($dsn, self::$configDB['USER_NAME'], self::$configDB['PASSWORD']);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            return "Failed to connect to database";
        }
    }
    public static function getInstance(): PDO|string
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance->pdoConnection ?? "Failed to connect to database";
    }
}
