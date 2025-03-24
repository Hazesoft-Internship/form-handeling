<?php

namespace HazeSoft\Backend\formHandeling\config;

use mysqli;
use Exception;

class DatabaseConnection
{
    const SERVER_NAME = "127.0.0.1";
    const USER_NAME = "root";
    const DATABASE = "ecommerce";
    const PASSWORD = "";

    public function connectDB(): mysqli|string
    {
        try {
            $connection = mysqli_connect(self::SERVER_NAME, self::USER_NAME, self::PASSWORD, self::DATABASE);

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
