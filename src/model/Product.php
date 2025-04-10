<?php

namespace ayushtamang\FormHandeling\model;
use ayushtamang\FormHandeling\controls\Validation;

class Product extends Validation
{
    public function __construct(private $con) 
    {
        $this->con = $con;
    }

    public function addProduct($userId, $productName, $productPrice, $productQuantity) 
    {
        try {
            $this->validateString($productName, "Product Name");
            $this->validateNumber($productPrice, "Product Price");
            $this->validateNumber($productQuantity, "Product Quantity");

            $query = $this->con->prepare("INSERT INTO products (userId, productName, productPrice, productQuantity) 
                                        VALUES (:ui, :pn, :pp, :pq)");
            $query->bindParam(':ui', $userId);
            $query->bindParam(':pn', $productName);
            $query->bindParam(':pp', $productPrice);
            $query->bindParam(':pq', $productQuantity);
            
            return $query->execute();
        } catch (\PDOException $e) {
            throw new \PDOException("AddProduct failed: " . $e->getMessage());
        }
    }

    public function updateProduct($userId, $productName, $productPrice, $productQuantity, $id)
    {
       try {
            $this->validateString($productName, "Product Name");
            $this->validateNumber($productPrice, "Product Price");
            $this->validateNumber($productQuantity, "Product Quantity");

            $query = $this->con->prepare("UPDATE products SET userId = :ui, productName = :pn, productPrice = :pp, productQuantity = :pq WHERE id = :id");
            $query->bindParam(':ui', $userId);
            $query->bindParam(':pn', $productName);
            $query->bindParam(':pp', $productPrice);
            $query->bindParam(':pq', $productQuantity);
            $query->bindParam(':id', $id);
            
            return $query->execute();
       } catch (\PDOException $e) {
            throw new \PDOException("UpdateProduct failed: " . $e->getMessage());
       }
    }

    public function deleteProduct($id)
    {
        $query = $this->con->prepare("DELETE FROM products WHERE id = :id");
        $query->bindParam(":id", $id);

        return $query->execute();
    }
}
?>