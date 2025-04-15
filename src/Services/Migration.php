<?php

namespace Hazesoft\Backend\Services;

use Exception;
use Hazesoft\Backend\Services\Connection;

class Migration
{
    private $conn;
    private static $instance = null;
    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function createUsersTableIfNotExists()
    {
        try {
            $query = "USE mydb;
            CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255) NOT NULL,
            middle_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            address VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at DATETIME,
            updated_at DATETIME
        );";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (Exception $exception) {
            echo "Error creating users table: " . $exception->getMessage();
        }
    }

    public function createProductsTableIfNotExists()
    {
        try {
            $query = "USE mydb;
            CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            price DECIMAL(12,2) NOT NULL,
            quantity INT NOT NULL,
            created_at DATETIME,
            updated_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (Exception $exception) {
            echo "Error creating products table: " . $exception->getMessage();
        }
    }

    public function createCartItemsTableIfNotExists()
    {
        try {
            $query = "USE mydb;
            CREATE TABLE IF NOT EXISTS cart_items (
            user_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY (user_id, product_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            );";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (Exception $exception) {
            echo "Error creating cart items table: " . $exception->getMessage();
        }
    }
}
