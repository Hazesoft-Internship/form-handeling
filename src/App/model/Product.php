<?php

namespace App\model;


class Product
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addProduct(string $name, int $price, int $quantity, int $userId)
    {

        $query = "insert into products (user_id,name,price,quantity) values (?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isii", $userId, $name, $price, $quantity);
        if ($stmt->execute()) {
            echo "product added";
        } else {
            echo "something went wrong while adding a product";
        }
    }

    public function getProducts(): array
    {
        $products = [];
        $query = "select * from products where user_id != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $Storedproducts = $stmt->get_result();
        while ($row = $Storedproducts->fetch_assoc()) {
            $products[] = $row;
        }
        var_dump($products, "products");
        return $products;
    }

    public function getAllProducts()
    {
        $products = [];
        $query = "select * from products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $store = $stmt->get_result();
        while ($row = $store->fetch_assoc()) {
            $products[] = $row;
        }
        // var_dump($products, "products");
        return $products;
    }

    public function deleteProduct($id)
    {

        $query = "delete from products where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: ../view/product.php");
        } else {
            echo $id;
            echo "something went wrong";
        }
    }
}
