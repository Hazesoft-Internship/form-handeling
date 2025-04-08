<?php

namespace ECommerce\Models;

use ECommerce\Services\DatabaseConnection;
use PDO;
use PDOException;

final class Product
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = DatabaseConnection::getInstance();
    }

    public function addProduct($productName, $productPrice, $productQuantity, $userID)
    {
        try {
            $addProductQuery = "INSERT INTO products (userID, name, price, quantity) VALUES (:userID, :productName, :productPrice, :productQuantity)";
            $statement = $this->dbConnection->prepare($addProductQuery);
            $statement->bindParam(':productName', $productName);
            $statement->bindParam(':productPrice', $productPrice);
            $statement->bindParam(':productQuantity', $productQuantity);
            $statement->bindParam(':userID', $userID);

            return $statement->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateProduct($updateFields, $params)
    {
        try {

            $updateProductQuery = "UPDATE products SET " . implode(", ", $updateFields) . " WHERE id = :productID";
            $statement = $this->dbConnection->prepare($updateProductQuery);

            foreach ($params as $key => $value) {
                $statement->bindValue($key, $value);
            }

            return $statement->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function getUpdateProductByID($productID)
    {
        try {
            $getProductByIDQuery = "SELECT* FROM products WHERE id = :productID";
            $statement = $this->dbConnection->prepare($getProductByIDQuery);
            $statement->bindParam(':productID', $productID);
            $statement->execute();

            $productByID = $statement->fetch(PDO::FETCH_ASSOC);
            if ($productByID) {
                return $productByID;
            }
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteProduct($productID)
    {
        try {
            $deleteProductQuery = "DELETE FROM products WHERE id = :productID";
            $statement = $this->dbConnection->prepare($deleteProductQuery);
            $statement->bindParam(':productID', $productID);
            return $statement->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function listAllProduct($userID)
    {
        try {
            $listProductQuery = "SELECT * FROM products WHERE NOT userID = :userID";
            $statement = $this->dbConnection->prepare($listProductQuery);
            $statement->bindParam(':userID', $userID);
            $statement->execute();

            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
            if ($products) {
                return $products;
            }
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function listMyProduct($userID)
    {
        try {
            $listProductQuery = "SELECT * FROM products WHERE userID = :userID";
            $statement = $this->dbConnection->prepare($listProductQuery);
            $statement->bindParam(':userID', $userID);
            $statement->execute();

            $myProducts = $statement->fetchAll(PDO::FETCH_ASSOC);

            if ($myProducts) return $myProducts;
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
