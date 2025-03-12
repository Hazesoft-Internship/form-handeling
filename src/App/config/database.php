<?php
class database
{
    private static $server = "localhost";
    private static $username = "phpmyadmin";
    private static $password = "Smith@123";
    private static $dbName = "hazesoft";

    public static function connectDB()
    {
        $conn = new mysqli(self::$server, self::$username, self::$password, self::$dbName);
        if ($conn->connect_error) {
            die("couldnot connect to database" . $conn->connect_error);
        } else {
            echo "connected to database";
            return $conn;
        }
    }
}
