<?php

namespace formhandeling\models;

use formhandeling\config\Database;

use Exception;
use mysqli_sql_exception;

require_once __DIR__ . '/../config/db.php';

class User
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function register($fName, $mName, $lName, $address, $email, $password): bool
    {

        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("INSERT INTO users (first_name, middle_name, last_name, address, email, password) VALUES (?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            throw new Exception("Database preparation error: " . $this->connection->error);
        }

        $stmt->bind_param("ssssss", $fName, $mName, $lName, $address, $email, $passwordhash);

        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                throw new Exception("Email already exists. Please use a different email.");
            } else {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }
        return true;
    }

    public function login($email, $password)
    {
        $stmt = $this->connection->prepare("SELECT id,first_name,password from users where email=?");

        if (!$stmt) {
            throw new Exception("Database preparation error: " . $this->connection->error);
        }

        $stmt->bind_param("s", $email);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $users = $result->fetch_assoc();
            if (password_verify($password, $users['password'])) {
                return $users;
            }
        }
        return false;
    }

    public function addproduct($productname, $productquantity, $productprice)
    {

        $userid = $_SESSION['id'];

        $stmt = $this->connection->prepare("INSERT INTO products (name, quantity, price, userid) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            throw new Exception("Database preparation error: " . $this->connection->error);
        }

        $stmt->bind_param("sidi", $productname, $productquantity, $productprice, $userid);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
        return true;
    }
}
