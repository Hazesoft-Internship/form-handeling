<?php

namespace Hazesoft\Formhandeling\Models;

use Hazesoft\Formhandeling\Services\Database;
use Hazesoft\Formhandeling\Services\Session;
use Exception;
use PDO;
use PDOException;

$session = Session::getInstance();

$session->start();

class Product
{
    private $connection;
    private $userid;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
        $this->userid = $_SESSION['id'] ?? null;
    }


    public function addProduct($productname, $productquantity, $productprice)
    {
        try {
            $stmt = $this->connection->prepare("
            INSERT INTO products (name, quantity, price, userid) 
            VALUES (:name, :quantity, :price, :userid)
        ");

            $stmt->bindParam(':name', $productname);
            $stmt->bindParam(':quantity', $productquantity, PDO::PARAM_INT);
            $stmt->bindParam(':price', $productprice);
            $stmt->bindParam(':userid', $this->userid, PDO::PARAM_INT);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    public function getProductsForDashboard()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM products");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    public function getOtherUsersProducts()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM products WHERE userid != :userid");
            $stmt->bindParam(':userid', $this->userid, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }




    public function getUserProducts()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM products WHERE userid = :userid");
            $stmt->bindParam(':userid', $this->userid, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }


    // Read – Get a single product by id.
    public function getProductById($productId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM products WHERE productid = :productid");
            $stmt->bindParam(':productid', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }


    public function updateProduct($id, $name, $quantity, $price)
    {
        try {
            $stmt = $this->connection->prepare("
            UPDATE products 
            SET name = :name, quantity = :quantity, price = :price 
            WHERE productid = :productid AND userid = :userid
        ");

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':productid', $id, PDO::PARAM_INT);
            $stmt->bindParam(':userid', $this->userid, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }


    public function deleteProduct($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM products WHERE productid = :productid AND userid = :userid");

            $stmt->bindParam(':productid', $id, PDO::PARAM_INT);
            $stmt->bindParam(':userid', $this->userid, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
}
