<?php

namespace Lattefront\FormHandeling\Module;

use Lattefront\FormHandeling\session\Session;
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

    public function insertProduct(): void
    {
        try {
            $product_name = $_POST['product_name'];
            $product_quantity = $_POST['product_quantity'];
            $product_price = $_POST['product_price'];
            $product_description = $_POST['product_description'];

            // attach created by in table

            if ($this->session->isLoggedIn()) {
                $logged_in_email = $this->session->getLoggedInUser();
            } else {
                die("User not logged in.");
            }

            // Validate the inputs
            if (empty($product_name) || empty($product_quantity) || empty($product_price) || empty($product_description)) {
                die("All fields are required.");
            }
            $sql = "INSERT INTO products ( productName, price, description, quantity,created_by) VALUES (?, ?, ?, ?,?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $product_name, PDO::PARAM_STR);
            $stmt->bindValue(2, $product_price, PDO::PARAM_STR);
            $stmt->bindValue(3, $product_description, PDO::PARAM_STR);
            $stmt->bindValue(4, $product_quantity, PDO::PARAM_STR);
            $stmt->bindValue(5, $logged_in_email, PDO::PARAM_STR);


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

            $stmt = null;
        }
    }
    public function getmyProducts()
    {
        try {

            if ($this->session->isLoggedIn()) {
                $loggedinemail = $this->session->getLoggedInUser();
            } else {
                echo "User not logged in.";
                echo "<br>";
                echo "You will be redirected to the login page in 3 seconds.";
                header("Refresh:3; url=/login");
            }

            $sql = "SELECT * FROM products where created_by = '$loggedinemail'";

            $result = $this->conn->query($sql);
            $products = [];

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $products[] = $row;
                }
                return $products;
            } else {
                echo "No products found.";
            }
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage(),);
        } finally {
            unset($this->conn);
        }
    }
    public function viewallProducts()
    {
        try {
            $sql = "SELECT * FROM products";

            $result = $this->conn->query($sql);
            $products = [];

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $products[] = $row;
                }
                return $products;
            } else {
                echo "No products found.";
            }
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage(),);
        }
    }
    public function updateProduct()
    {
        if ($this->session->isLoggedIn()) {
            $loggedinemail = $this->session->getLoggedInUser();
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


            $stmt->bindValue(1, $name, PDO::PARAM_STR);
            $stmt->bindValue(2, $quantity, PDO::PARAM_INT);
            $stmt->bindValue(3, $price, PDO::PARAM_STR);
            $stmt->bindValue(4, $description, PDO::PARAM_STR);
            $stmt->bindValue(5, $loggedinemail, PDO::PARAM_STR);
            $stmt->bindValue(6, $id, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                echo "Product $id updated successfully.";
                echo "<br>";
                echo "You will be redirected to the dashboard page in 3 seconds.";
                header("Refresh:3; url=/dashboard");
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "Failed to update product: " . $errorInfo[2];
            }
        } catch (\mysqli_sql_exception $e) {
            throw new Exception("Database error: " . $e->getMessage());
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage());
        } finally {
            if (isset($stmt)) {
                $stmt = null;
            }
        }
    }
    public function deleteProduct(): void
    {
        try {

            $productID = $_POST['id'];

            $sql = "DELETE FROM products WHERE productID= ? ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $productID, PDO::PARAM_INT);


            if ($stmt->execute()) {
                echo "Product {$productID} deleted successfully.";
                echo "<br>";
                echo "You will be redirected to the dashboard page in 3 seconds.";
                header("Refresh:3; url=/dashboard");
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "Failed to delete product: " . $errorInfo[2];
            }
        } catch (\mysqli_sql_exception $e) {
            throw new Exception("Database error: " . $e->getMessage());
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage());
        } finally {
            if (isset($stmt)) {
                $stmt = null;
            }
        }
    }
}
