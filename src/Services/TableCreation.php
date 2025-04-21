<?php

namespace Hazesoft\Backend\Services;

use Exception;
use Hazesoft\Backend\Services\Connection;

class TableCreation
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
            type ENUM('physical', 'digital') NOT NULL,
            tax DECIMAL(7,2) NOT NULL DEFAULT 13.00,
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
            cart_id INT NOT NULL,
            quantity INT NOT NULL,
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY (user_id, product_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            FOREIGN KEY (cart_id) REFERENCES carts(id)
            );";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (Exception $exception) {
            echo "Error creating cart items table: " . $exception->getMessage();
        }
    }

    public function createCartsTableIfNotExists()
    {
        try {
            $query = "USE mydb;
            CREATE TABLE IF NOT EXISTS carts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            created_at DATETIME,
            updated_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id)
            );
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (Exception $exception) {
            echo "Error creating carts table: " . $exception->getMessage();
        }
    }
    public function createOrderItemsTableIfNotExists()
    {
        try {
            $query = "USE mydb;
            CREATE TABLE IF NOT EXISTS order_items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                unit_price DECIMAL(12, 2) NOT NULL,
                total_price_after_tax DECIMAL(12, 2) NOT NULL,
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            );";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (Exception $exception) {
            echo "Error creating order_items table: " . $exception->getMessage();
        }
    }

    public function createOrdersTableIfNotExists()
    {
        try {
            $query = "USE mydb;
            CREATE TABLE IF NOT EXISTS orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                cart_id INT NOT NULL,
                address VARCHAR(255) NOT NULL,
                status ENUM('pending', 'shipped', 'delivered') DEFAULT 'pending',
                payment_type ENUM('Cash on Delivery', 'eSewa', 'Khalti') NOT NULL,
                tax DECIMAL(10, 2) NOT NULL,
                total DECIMAL(12, 2) NOT NULL,
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE
            );";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (Exception $exception) {
            echo "Error creating orders table: " . $exception->getMessage();
        }
    }
}
