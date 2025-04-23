<?php

namespace ECommerce\Models;

use ECommerce\Models\ModelDBConnection;
use PDO;
use PDOException;
use PDOStatement;

final class Product extends ModelDBConnection
{

    public function getUpdateProductByID(int $productID): array|string
    {
        try {
            $getProductByIDQuery = "SELECT* FROM products WHERE id = :productID";
            $statement = $this->dbConnection->prepare($getProductByIDQuery);
            $statement->bindParam(':productID', $productID);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addProduct(string $productName, string $productPrice, int $productQuantity, string $productType, int $userID): PDOStatement|string
    {
        try {
            $addProductQuery = "INSERT INTO products (userID, name, price, quantity,type) VALUES (:userID, :productName, :productPrice, :productQuantity,:productType)";
            $statement = $this->dbConnection->prepare($addProductQuery);
            $statement->bindParam(':productName', $productName);
            $statement->bindParam(':productPrice', $productPrice);
            $statement->bindParam(':productQuantity', $productQuantity);
            $statement->bindParam(':productType', $productType);
            $statement->bindParam(':userID', $userID);

            return $statement->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateProduct(array $updateFields, array $params): PDOStatement|string
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

    public function deleteProduct(int $productID): PDOStatement|string
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

    public function listAllProduct(int $userID): array|string
    {
        try {
            $listProductQuery = "SELECT id,userID,name,price,quantity FROM products WHERE NOT userID = :userID";
            $statement = $this->dbConnection->prepare($listProductQuery);
            $statement->bindParam(':userID', $userID);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function listMyProduct(int $userID): array|string
    {
        try {
            $listProductQuery = "SELECT * FROM products WHERE userID = :userID";
            $statement = $this->dbConnection->prepare($listProductQuery);
            $statement->bindParam(':userID', $userID);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deductProductQuantity(int $productID, int $quantity): PDO|string
    {
        try {
            $deductProductQuantityQuery = 'UPDATE products SET quantity = GREATEST(quantity - :quantity, 0) WHERE id = :productID';
            $statement = $this->dbConnection->prepare($deductProductQuantityQuery);
            $statement->bindParam(':quantity', $quantity);
            $statement->bindParam(':productID', $productID);

            return $statement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
