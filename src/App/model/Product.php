<?php

namespace App\model;

session_start();

class Product
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addProduct(string $name, int $price, int $quantity)
    {
        $query = "insert into products (user_id,name,price,quantity) values (?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isii", $_SESSION["user_id"], $name, $price, $quantity);
        if ($stmt->execute()) {
            echo "product added";
        } else {
            echo "something went wrong while adding a product";
        }
    }
}
