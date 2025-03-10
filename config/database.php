<?php

class connectDatabase
{
    private const server = "localhost";
    private const username = "phpmyadmin";
    private const password = "Smith@123";
    private const dbName = "hazesoft";
    public static function getConnection()
    {
        $conn = new mysqli(self::server, self::username, self::password, self::dbName);
        if ($conn->connect_error) {
            die("connection failed" . $conn->connect_error);
        }
        echo "connected to database";
        return $conn;
    }
}
$connection = connectDatabase::getConnection();
