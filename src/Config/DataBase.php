<?php

namespace App\Config;



use mysqli;
use Exception;
use PDO;



class DataBase
{

    public static $connection = null;
    private static string $servername;
    private static string $password;
    private static string $dbname;
    private static string $username;

    public static function init()
    {
        self::$servername = $_ENV['DB_HOST'];
        self::$username = $_ENV['DB_USER'];
        self::$password = $_ENV['DB_PASS'];
        self::$dbname = $_ENV['DB_NAME'];
    }


    public static function connect(): object|null
    {
        if (self::$connection == null) {
            try {
                self::init();
                $pdo = new PDO("mysql:host=" . self::$servername . ";" . "dbname=" . self::$dbname, self::$username, self::$password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                return self::$connection = $pdo;
            } catch (\PDOException $exception) {

                die("Connection failed: " . $exception->getMessage());
            }
        } else {
            return self::$connection;
        }
    }
}
