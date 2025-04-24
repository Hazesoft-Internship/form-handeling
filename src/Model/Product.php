<?php

namespace App\Model;
require_once __DIR__."/../../vendor/autoload.php";

use App\Model\Database;
use App\session\session;

class Product extends GetConnection
{
    public function addProduct($productName, $quantity, $price, $userID): void
    {
        $stmt = $this->conn->prepare("INSERT INTO products(userID, productName, quantity, price) VALUES (:userID, :productName, :quantity, :price)");

        if (!$stmt) {
            throw new RuntimeException("Unable to prepare the statement for product");
        }
        $stmt->bindParam(':userID',$userID);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);

        if (!$stmt->execute()) {
            throw new RuntimeException("Unable to execute the query for Product addition");
        }
        else {
            header("Location: /viewYourProduct");
        }
    }

    public function viewAllProduct($userID): array
    {
        $sql = "SELECT * FROM products where userID != '$userID'";
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }

    public function viewYourProduct($userID): array
    {
        $sql = "SELECT * FROM products WHERE userID='$userID'";
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }

    public function deleteProduct($id): void
    {
        $sql = "DELETE FROM products WHERE id=$id";
        if(($this->conn->query($sql)) == TRUE)
        {
            header("Location: /viewYourProduct");
        }
        else
        {
            echo "deletion failed";
        }
    }

    public function updateProduct($updatedPrice, $updatedQuantity, $id): void
    {
        $query = "UPDATE products SET quantity = $updatedQuantity, price = $updatedPrice WHERE id=$id";
        if(($this->conn->query($query)) == TRUE)
        {
            header("Location: /viewYourProduct");
        }
        else
        {
            echo "update failed";
        }
    }

    public function readUpdate($id): array
    {
        $sql = "SELECT * FROM products WHERE id = $id";
        $result = $this->conn->query($sql);
        
        if($result)
        {
            return $result->fetch();
        }
        else
        {
            echo "Product not found on database";
        }
    }
}
