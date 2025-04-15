<?php

declare(strict_types=1);

namespace src\Config;

use PDO;
use PDOException;
use App\Exceptions\DatabaseException;

class DB
{
    private static ?PDO $conn = null;

    public static function getConnection(): PDO
    {
        if (self::$conn === null) {
            $host = 'localhost';
            $db = 'form';
            $user = 'root';
            $pass = '';

            try {
                self::$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new DatabaseException("Connection failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
