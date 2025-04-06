<?php

namespace Lattefront\FormHandeling\Module;

session_start();


use Lattefront\FormHandeling\Db\DbConnection;
use mysqli;
use Exception;

class Product
{
    private mysqli $conn; // Store the mysqli connection

    public function __construct(DbConnection $dbConnection)
    {
        $this->conn = $dbConnection->getConnection(); // Get the mysqli connection
    }
    public function insertProduct(): void
    {
        try {
            $product_name = $_POST['product_name'];
            $product_quantity = $_POST['product_quantity'];
            $product_price = $_POST['product_price'];
            $product_description = $_POST['product_description'];

            // attach created by in table

            if (isset($_SESSION['email'])) {
                $logged_in_email = $_SESSION['email'];
            } else {
                die("User not logged in.");
            }

            // Validate the inputs
            if (empty($product_name) || empty($product_quantity) || empty($product_price) || empty($product_description)) {
                die("All fields are required.");
            }
            $sql = "INSERT INTO products ( productName, price, description, quantity,created_by) VALUES (?, ?, ?, ?,?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssss", $product_name, $product_price, $product_description, $product_quantity, $logged_in_email);


            if ($stmt->execute()) {
                echo "Product inserted successfully.";
                echo "<br>";
                echo "You will be redirected to the dashboard in 3 seconds.";
                header("Refresh:3; url=/dashboard");
            }
        } catch (\mysqli_sql_exception $e) {
            throw new Exception("" . $e->getMessage() . "");
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage(),);
        } finally {

            $stmt->close();
        }
    }
    public function getAllProducts()
    {
        try {
            if (isset($_SESSION['email'])) {
                $loggedinemail = $_SESSION['email'];
            } else {
                echo "User not logged in.";
                echo "<br>";
                echo "You will be redirected to the login page in 3 seconds.";
                header("Refresh:3; url=/login");
            }

            $sql = "SELECT * FROM products where created_by = '$loggedinemail'";

            $result = $this->conn->query($sql);
            $products = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return $products;
            } else {
                echo "No products found.";
            }
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage(),);
        } finally {
            $this->conn->close();
        }
    }
    public function updateProduct()
    {
        if (isset($_SESSION['email'])) {
            $loggedinemail = $_SESSION['email'];
        } else {
            echo "User not logged in.";
            echo "<br>";
            echo "You will be redirected to the login page in 3 seconds.";
            header("Refresh:3; url=/login");
        }
        try {
            $id = $_POST['id'];
            $name = $_POST['product_name'];
            $quantity = $_POST['product_quantity'];
            $price = $_POST['product_price'];
            $description = $_POST['product_description'];

            // Validate inputs
            if (empty($id) || empty($name) || empty($quantity) || empty($price) || empty($description)) {
                die("All fields are required.");
            }

            $sql = "UPDATE products SET productName = ?, quantity = ?, price = ?, description = ? ,updated_by=? WHERE productID = ?";
            $stmt = $this->conn->prepare($sql);


            $stmt->bind_param("sidssi", $name, $quantity, $price, $description, $loggedinemail, $id);

            // Execute the query
            if ($stmt->execute()) {
                echo "Product updated successfully.";
                echo "<br>";
                echo "You will be redirected to the dashboard page in 3 seconds.";
                header("Refresh:3; url=/dashboard");
            } else {
                echo "Failed to update product: " . $stmt->error;
            }
        } catch (\mysqli_sql_exception $e) {
            throw new Exception("Database error: " . $e->getMessage());
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage());
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
    public function deleteProduct(): void
    {
        try {

            $productID = $_POST['id'];

            $sql = "DELETE FROM products WHERE productID= ? ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $productID);

            if ($stmt->execute()) {
                echo "Product deleted successfully.";
                echo "<br>";
                echo "You will be redirected to the dashboard page in 3 seconds.";
                header("Refresh:3; url=/dashboard");
            } else {
                echo "Failed to delete product: " . $stmt->error;
            }
        } catch (\mysqli_sql_exception $e) {
            throw new Exception("Database error: " . $e->getMessage());
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage());
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
}
