<?php

namespace App\Config;

use mysqli;
use Exception;
use PDO;

class DataBase
{

    public static $connection = null;
    private static string $servername = "localhost";
    private static string $username = "php";
    private static string $password = "password";
    private static string $dbname = "testdb";



    public static function connect(): object|null
    {
        if (self::$connection == null) {
            try {
                // $connection = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
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
