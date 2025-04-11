<?php

namespace Hazesoft\Backend\Models;

use Exception;
use Hazesoft\Backend\Services\Connection;
use Hazesoft\Backend\Services\Session;

class Product
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }
    public function insertProductDetails($inputArray)
    {
        try {
            [$productName, $productPrice, $productQuantity] = $inputArray;
            $session = Session::getInstance();
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            $user_id = (int)$session->getSession("userId") ?? '';

            $sql = "INSERT INTO `products` (`user_id`, `name`, `price`, `quantity`, `created_at`, `updated_at`) VALUES (:user_id, :name, :price, :quantity, :created_at, :updated_at)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':name', $productName);
            $stmt->bindParam(':price', $productPrice);
            $stmt->bindParam(':quantity', $productQuantity);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':updated_at', $updated_at);

            return $stmt->execute();

        } catch (Exception $exception) {
            echo ("Error inserting product " . $exception->getMessage());
            return false;
        }
    }

    public function getAllProducts()
    {
        try {
            $query = "SELECT * from products";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(); // Return products array
        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }

    public function getUserProducts($userId)
    {
        try {
            $query = "SELECT * FROM products WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }
    public function getOtherProducts($userId)
    {
        // returns all product except for user's
        try {
            $query = "SELECT * FROM products WHERE user_id != :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }

    public function getProductById($productId)
    {
        try {
            $query = "SELECT * FROM products WHERE id = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':product_id', $productId);
            $stmt->execute();

            return $stmt->fetch();

        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function deleteProduct($productId)
    {
        try {
            $query = "DELETE FROM products WHERE id = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':product_id', $productId);
            $result = $stmt->execute();

            if ($result) {
                header("Location: /products");
            } else {
                echo "Product deletion went wrong";
            }
        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }

    public function updateProduct($productId, array $product)
    {
        try {
            [$productName, $productPrice, $productQuantity] = $product;

            $updated_at = date('Y-m-d H:i:s');
            $query = "UPDATE products SET name = :product_name, price = :product_price, quantity = :product_quantity, updated_at = :updated_at WHERE id = :product_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':product_name', $productName);
            $stmt->bindParam(':product_price', $productPrice);
            $stmt->bindParam(':product_quantity', $productQuantity);
            $stmt->bindParam(':updated_at', $updated_at);
            $stmt->bindParam(':product_id', $productId);

            $result = $stmt->execute();

            if (!$result) {
                echo "Error updating product, Product Name: {$productName}";
            }
        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }
}
