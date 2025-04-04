<?php

namespace App\Config;

use mysqli;
use Exception;


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
                $connection = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);

                if ($connection->connect_error) {
                    throw new Exception("Could not connect: " . $connection->connect_error);
                }

                // echo "Connected successfully";

                return self::$connection = $connection;
            } catch (Exception $exception) {
                echo "Error: " . $exception->getMessage();
                die("Connection failed: " . $exception->getMessage());
            }
        } else {
            return self::$connection;
        }
    }
}
