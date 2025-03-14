<?php

class DatabaseConnection
{
    private $servername = "127.0.0.1";
    private $username = "root";
    private $database = "ecommerce";
    private $password = "";

    public function connectDB(): mysqli|string
    {
        $connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database);

        if (!$connection) {
            return "Failed to connect to database";
        }

        return $connection;
    }
}
