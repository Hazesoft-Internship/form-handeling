<?php

namespace Product\Classes;

require_once '../config/db.php';

use PDO;

class Product
{
    private $conn;
    private $table_name = "products";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addProduct($user_id, $product_name, $price, $quantity)
    {
        $user_id      = (int)$user_id;
        $product_name = htmlspecialchars(strip_tags((string)$product_name));
        $price        = (!empty($price)) ? (float)$price : 0.0;
        $quantity     = (!empty($quantity)) ? (int)$quantity : 0;

        // Check if the product already exists for the user
        $query = "SELECT id, price, quantity FROM " . $this->table_name . " WHERE user_id = :user_id AND product_name = :product_name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Update existing product
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $newPrice = (float)$row['price'] + $price;
            $newQuantity = (int)$row['quantity'] + $quantity;

            $updateQuery = "UPDATE " . $this->table_name . " SET price = :price, quantity = :quantity, updated_at = NOW() WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':price', $newPrice);
            $updateStmt->bindParam(':quantity', $newQuantity);
            $updateStmt->bindParam(':id', $row['id']);
            if ($updateStmt->execute()) {
                return true;
            }
            $errorInfo = $updateStmt->errorInfo();
            return "Error: " . $errorInfo[2];
        } else {
            // Insert new product
            $insertQuery = "INSERT INTO " . $this->table_name . " (user_id, product_name, price, quantity, created_at, updated_at) VALUES (:user_id, :product_name, :price, :quantity, NOW(), NOW())";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bindParam(':user_id', $user_id);
            $insertStmt->bindParam(':product_name', $product_name);
            $insertStmt->bindParam(':price', $price);
            $insertStmt->bindParam(':quantity', $quantity);
            if ($insertStmt->execute()) {
                return true;
            }
            $errorInfo = $insertStmt->errorInfo();
            return "Error: " . $errorInfo[2];
        }
    }

    public function removeProduct($user_id, $product_name, $price, $quantity)
    {
        $user_id      = (int)$user_id;
        $product_name = htmlspecialchars(strip_tags((string)$product_name));
        $price        = (!empty($price)) ? (float)$price : 0.0;
        $quantity     = (!empty($quantity)) ? (int)$quantity : 0;

        // Check if the product exists for the user
        $query = "SELECT id, quantity, price FROM " . $this->table_name . " WHERE user_id = :user_id AND product_name = :product_name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Update existing product
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $newQuantity = (int)$row['quantity'] - $quantity;
            $newPrice = (float)$row['price'] - $price;
            if ($newQuantity <= 0) {
                // Delete the product if quantity is zero or less
                $deleteQuery = "DELETE FROM " . $this->table_name . " WHERE id = :id";
                $deleteStmt = $this->conn->prepare($deleteQuery);
                $deleteStmt->bindParam(':id', $row['id']);
                if ($deleteStmt->execute()) {
                    return true;
                }
                $errorInfo = $deleteStmt->errorInfo();
                return "Error: " . $errorInfo[2];
            } else {
                // Update the product if the quantity is greater than zero
                $updateQuery = "UPDATE " . $this->table_name . " SET quantity = :quantity, price = :price, updated_at = NOW() WHERE id = :id";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bindParam(':quantity', $newQuantity);
                $updateStmt->bindParam(':price', $newPrice);
                $updateStmt->bindParam(':id', $row['id']);
                if ($updateStmt->execute()) {
                    return true;
                }
                $errorInfo = $updateStmt->errorInfo();
                return "Error: " . $errorInfo[2];
            }
        } else {
            return "Product not found.";
        }
    }

    public function getProducts()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
