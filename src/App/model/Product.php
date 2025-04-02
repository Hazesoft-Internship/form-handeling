<?php

namespace App\model;


class Product
{
    public function __construct(private $conn)
    {
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

    public function getMyProducts($id) {
        $products = [];
        $query = "select * from products where user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $store = $stmt->get_result();
        while($row = $store->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    public function deleteProduct($id)
    {

        $query = "delete from products where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: ../view/myProduct.php");
        } else {
            echo $id;
            echo "something went wrong";
        }
    }

    public function getSingleProduct(int $id): array
    {
        $query = "select * from products where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $store = $stmt->get_result();
        $row = $store->fetch_assoc();
        return $row;
    }

    public function updateProduct($productId, $productName, $productQuantity, $productPrice) {

        $query = "update products
                  set name = ?, price = ?, quantity = ?
                  where id = ?"
                   ;
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("siii", $productName, $productPrice, $productQuantity, $productId );
        if($stmt->execute()) {
            header("Location: ../view/myProduct.php");
        } else {
            
            echo "something went wrong while updating";
        }
    }
}
