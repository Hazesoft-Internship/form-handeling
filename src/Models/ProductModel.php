<?php

namespace App\Models;

use App\Config\DataBase;




use Exception;


class ProductModel
{
    public object $connection;

    public function __construct()
    {
        $this->connection = DataBase::connect();
    }

    public function insertProduct(string $name,  string $description, float $price, int $quantity, int $userId): void
    {
        try {
            $sql = "INSERT INTO products (name, description, price,quantity,user_id) VALUES ( ?, ?,?,?,?)";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("ssdii", $name, $description, $price, $quantity, $userId);

            if ($statement->execute()) {
                echo "Product added successfully!";
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }
            $statement->close();
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function updateProduct(int $id, string $name, string $description, float $price, int $quantity): bool
    {
        try {
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, quantity = ? WHERE product_id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("ssdii", $name, $description, $price, $quantity, $id);

            if ($statement->execute()) {
                echo "Product updated successfully!";
                return true;
            } else {
                return false;
            }
            $statement->close();
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function deleteProduct(int $id): bool
    {
        try {
            $sql = "DELETE FROM products WHERE product_id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("i", $id);

            if ($statement->execute()) {
                echo "Product deleted successfully!";
                return true;
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }
            $statement->close();
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }

    public function getAllProducts(): array
    {
        try {
            $sql = "SELECT * FROM products";
            $statement = $this->connection->prepare($sql);
            if ($statement->execute()) {
                $result = $statement->get_result();
                $products = $result->fetch_all(MYSQLI_ASSOC);
                $statement->close();
                return $products;
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function getUserProducts(int $userId): array
    {
        try {
            $sql = "SELECT * FROM products WHERE user_id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("i", $userId);

            if ($statement->execute()) {
                $result = $statement->get_result();
                $products = $result->fetch_all(MYSQLI_ASSOC);
                $statement->close();
                return $products;
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
}
