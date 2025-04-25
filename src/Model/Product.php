<?php

namespace Lattefront\FormHandeling\Model;

use Exception;
use PDO;

class Product extends Model
{

    // Insert new product into the database
    public function insertProduct(string $product_name, int $product_price, string $product_description, int $product_quantity, string $productTypes): void
    {
        try {
            $sql = "INSERT INTO products (productName, price, description, quantity, created_by, productTypes) VALUES (?, ?, ?, ?, ?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $product_name, PDO::PARAM_STR);
            $stmt->bindValue(2, $product_price, PDO::PARAM_STR);
            $stmt->bindValue(3, $product_description, PDO::PARAM_STR);
            $stmt->bindValue(4, $product_quantity, PDO::PARAM_INT);
            $stmt->bindValue(5, $this->session->getUserId(), PDO::PARAM_STR);
            $stmt->bindValue(6, $productTypes, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "Product inserted successfully.";
                echo "<br>";
                echo "You will be redirected to the dashboard in 2 seconds.";
                header("Refresh:2; url=/dashboard");
                exit();
            } else {
                throw new Exception("Failed to insert product.");
            }
        } catch (Exception $excep) {
            error_log($excep->getMessage());
            echo "An error occurred. Please try again later.";
            header("Refresh:2; url=/dashboard");
            exit();
        }
    }

    //  products created by the logged-in user
    public function getmyProducts($loggedinemail): array
    {
        try {

            $sql = "SELECT * FROM products WHERE created_by = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $this->session->getUserId(), PDO::PARAM_STR);
            $stmt->execute();

            $products = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[] = $row;
            }

            return $products;
        } catch (Exception $excep) {
            error_log($excep->getMessage());
            throw new Exception("Error: " . $excep->getMessage());
        }
    }

    // Get all products from the database
    public function viewallProducts($loggedinemail): array
    {
        try {

            if ($loggedinemail == null) {

                $sql = "SELECT * FROM products";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
            } else {
                $sql = "SELECT * FROM products WHERE created_by != ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(1, $this->session->getUserId(), PDO::PARAM_STR);
                $stmt->execute();
            }

            $products = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[] = $row;
            }

            return $products;
        } catch (Exception $excep) {
            error_log($excep->getMessage());
            throw new Exception("Error: " . $excep->getMessage());
        }
    }

    // Update an existing product
    public function updateProduct(int $id, string $name, int $quantity, int $price, string $description, string $productTypes): void
    {
        try {

            // Prepare SQL query
            $sql = "UPDATE products SET productName = ?, quantity = ?, price = ?, description = ?, updated_by = ?,productTypes=? WHERE productID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $name, PDO::PARAM_STR);
            $stmt->bindValue(2, $quantity, PDO::PARAM_INT);
            $stmt->bindValue(3, $price, PDO::PARAM_STR);
            $stmt->bindValue(4, $description, PDO::PARAM_STR);
            $stmt->bindValue(5, $this->session->getUserId(), PDO::PARAM_STR);
            $stmt->bindValue(6, $productTypes, PDO::PARAM_STR);
            $stmt->bindValue(7, $id, PDO::PARAM_INT);
            // Execute the query
            if ($stmt->execute()) {
                echo "Product {$id} updated successfully.";
                echo "<br>";
                echo "You will be redirected to the dashboard page in 2 seconds.";
                header("Refresh:2; url=/dashboard");
                exit();
            } else {
                throw new Exception("Failed to update product.");
            }
        } catch (Exception $excep) {
            error_log($excep->getMessage());
            echo "An error occurred. Please try again later.";
            header("Refresh:2; url=/dashboard");
            exit();
        }
    }

    // Delete a product
    public function deleteProduct(int $productID): void
    {
        try {

            // Prepare SQL query
            $sql = "DELETE FROM products WHERE productID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $productID, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                echo "Product {$productID} deleted successfully.";
                echo "<br>";
                echo "You will be redirected to the dashboard page in 2 seconds.";
                header("Refresh:2; url=/dashboard");
                exit();
            } else {
                throw new Exception("Failed to delete product.");
            }
        } catch (Exception $excep) {
            error_log($excep->getMessage());
            echo "An error occurred. Please try again later.";
            header("Refresh:2; url=/dashboard");
            exit();
        }
    }
    //reduce product quantity after orderplaced
    public function reduceproductquantity($quantity, $productId): void
    {
        try {
            $query = $this->conn->prepare("UPDATE products SET quantity = quantity - ? WHERE productID = ?");
            $query->bindValue(1, $quantity, PDO::PARAM_INT);
            $query->bindValue(2, $productId, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $excep) {
            error_log($excep->getMessage());
            echo "An error occurred. Please try again later.";
            header("Refresh:2; url=/dashboard");
            exit();
        }
    }
    public function getproductdetails(int $productID): array
    {
        try {
            $sql = "SELECT quantity , created_by FROM products WHERE productID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $productID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return [(int)$row['quantity'], (string)$row['created_by']];
        } catch (Exception $excep) {
            error_log($excep->getMessage());
            throw new Exception("Error: " . $excep->getMessage());
        }
    }
}
