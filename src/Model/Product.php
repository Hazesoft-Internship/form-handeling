<?php

namespace Lattefront\FormHandeling\Model;

use Lattefront\FormHandeling\Session\Session;
use Lattefront\FormHandeling\Db\DbConnection;
use Exception;
use PDO;

class Product
{
    private PDO $conn; // Store the connection
    private Session $session; // Store the session instance

    public function __construct(DbConnection $dbConnection)
    {
        $this->session = Session::getInstance(); // Initialize the session instance
        $this->conn = $dbConnection->getConnection(); // Get the mysqli connection
    }

    // Helper method to check if user is logged in
    private function checkSession(): void
    {
        if (!$this->session->isLoggedIn()) {
            throw new Exception("User not logged in.");
        }
    }

    // Helper method to validate product input
    private function validateProductInput($product_name, $product_quantity, $product_price, $product_description): void
    {
        if (empty($product_name) || empty($product_quantity) || empty($product_price) || empty($product_description)) {
            throw new Exception("All fields are required.");
        }

        if (!is_numeric($product_quantity) || !is_numeric($product_price)) {
            throw new Exception("Quantity and price must be valid numbers.");
        }
    }

    // Insert new product into the database
    public function insertProduct(): void
    {
        try {
            $this->checkSession(); // Check if user is logged in

            // Sanitize and validate inputs
            $product_name = filter_var($_POST['product_name']);
            $product_quantity = filter_var($_POST['product_quantity']);
            $product_price = filter_var($_POST['product_price'], );
            $product_description = filter_var($_POST['product_description']);

            $this->validateProductInput($product_name, $product_quantity, $product_price, $product_description);

            // Prepare SQL query
            $sql = "INSERT INTO products (productName, price, description, quantity, created_by) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $product_name, PDO::PARAM_STR);
            $stmt->bindValue(2, $product_price, PDO::PARAM_STR);
            $stmt->bindValue(3, $product_description, PDO::PARAM_STR);
            $stmt->bindValue(4, $product_quantity, PDO::PARAM_INT);
            $stmt->bindValue(5, $this->session->getLoggedInUser(), PDO::PARAM_STR);

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

    // Get products created by the logged-in user
    public function getmyProducts(): array
    {
        try {
            $this->checkSession(); // Check if user is logged in

            $loggedinemail = $this->session->getLoggedInUser();

            $sql = "SELECT * FROM products WHERE created_by = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $loggedinemail, PDO::PARAM_STR);
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
    public function viewallProducts(): array
    {
        try {
            $sql = "SELECT * FROM products";
            $stmt = $this->conn->query($sql);

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
    public function updateProduct(): void
    {
        try {
            $this->checkSession(); // Check if user is logged in

            $id = $_POST['id'];
            $name = $_POST['product_name'];
            $quantity = $_POST['product_quantity'];
            $price = $_POST['product_price'];
            $description = $_POST['product_description'];

            // Sanitize and validate inputs
            $name = filter_var($name);
            $quantity = filter_var($quantity);
            $price = filter_var($price);
            $description = filter_var($description);

            $this->validateProductInput($name, $quantity, $price, $description);

            // Prepare SQL query
            $sql = "UPDATE products SET productName = ?, quantity = ?, price = ?, description = ?, updated_by = ? WHERE productID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $name, PDO::PARAM_STR);
            $stmt->bindValue(2, $quantity, PDO::PARAM_INT);
            $stmt->bindValue(3, $price, PDO::PARAM_STR);
            $stmt->bindValue(4, $description, PDO::PARAM_STR);
            $stmt->bindValue(5, $this->session->getLoggedInUser(), PDO::PARAM_STR);
            $stmt->bindValue(6, $id, PDO::PARAM_INT);

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
    public function deleteProduct(): void
    {
        try {
            $this->checkSession(); // Check if user is logged in

            $productID = $_POST['id'];

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
}

