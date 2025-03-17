<?php
namespace HazeSoft\Backend\formHandeling\config;
use mysqli;
use Exception;

class DatabaseConnection
{
    private $servername = "127.0.0.1";
    private $username = "root";
    private $database = "ecommerce";
    private $password = "";

    public function connectDB(): mysqli|string
    {
        try {
            $connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database);

            if (!$connection) {
                throw new Exception("Failed to connect to database: " . mysqli_connect_error());
            }

            return $connection;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return "Failed to connect to database";
        }
    }
}
