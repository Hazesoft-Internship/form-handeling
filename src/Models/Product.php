<?php

namespace Hazesoft\Formhandeling\Models;

class Product extends BaseModel
{
    public function addProduct($productname, $productquantity, $productprice, $types): bool
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO products (name, quantity, price, userid, types) 
            VALUES (:name, :quantity, :price, :userid, :types)");

            $stmt->bindParam(':name', $productname);
            $stmt->bindParam(':quantity', $productquantity, \PDO::PARAM_INT);
            $stmt->bindParam(':price', $productprice);
            $stmt->bindParam(':userid', $this->userid, \PDO::PARAM_INT);
            $stmt->bindParam(':types', $types, \PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }

    public function getProductsForDashboard(): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM products");
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }

    public function getOtherUsersProducts(): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM products WHERE userid != :userid");
            $stmt->bindParam(':userid', $this->userid, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }

    public function getUserProducts(): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM products WHERE userid = :userid");
            $stmt->bindParam(':userid', $this->userid, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }

    public function getProductById($productId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM products WHERE productid = :productid");
            $stmt->bindParam(':productid', $productId, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }

    public function updateProduct($id, $name, $quantity, $price, $types): bool
    {
        try {
            $stmt = $this->connection->prepare(" UPDATE products 
            SET name = :name, quantity = :quantity, price = :price, types = :types
            WHERE productid = :productid AND userid = :userid");

            $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $quantity, \PDO::PARAM_INT);
            $stmt->bindParam(':price', $price, \PDO::PARAM_INT);
            $stmt->bindParam(':productid', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':userid', $this->userid, \PDO::PARAM_INT);
            $stmt->bindParam(':types', $types, \PDO::PARAM_STR);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }

    public function updateProductQuantity(int $productId, int $quantity): void
    {
        try {
            $stmt = $this->connection->prepare("SELECT quantity FROM products WHERE productid = :product_id");
            $stmt->bindParam(':product_id', $productId, \PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch();

            if ($product) {
                $newQuantity = $product['quantity'] - $quantity;

                $stmt = $this->connection->prepare("UPDATE products SET quantity = :quantity WHERE productid = :product_id");
                $stmt->bindParam(':quantity', $newQuantity, \PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, \PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (\PDOException $e) {
            throw new \Exception("Failed to update product quantity: " . $e->getMessage());
        }
    }


    public function deleteProduct($id): bool
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM products WHERE productid = :productid AND userid = :userid");

            $stmt->bindParam(':productid', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':userid', $this->userid, \PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
}
