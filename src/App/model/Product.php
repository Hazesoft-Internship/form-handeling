<?php

namespace App\model;

use App\Exception\CustomException;
use App\validate\ProductValidation;

class Product
{
    private $validate;
    public function __construct(private $conn)
    {

        $this->validate = new ProductValidation();
    }

    public function addProduct(string $name, int $price, int $quantity, string $type, int $userId)
    {
        $query = "insert into products (user_id,name,price,quantity,type) values (:userId,:name,:price,:quantity,:type)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":userId", $userId);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":price", $price);
        $stmt->bindValue(":quantity", $quantity);
        $stmt->bindValue(":type", $type);
        if ($stmt->execute()) {
            header("Location: /my-profile");
        } else {
            echo "something went wrong while adding a product";
        }
    }

    public function getProducts(): array
    {
        $products = [];
        $query = "select * from products where user_id != :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":userId", $_SESSION["user_id"]);
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
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
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $products[] = $row;
        }
        return $products;
    }

    public function getMyProducts($id)
    {
        $products = [];
        $query = "select * from products where user_id = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":userId", $id);
        $stmt->execute();

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $products[] = $row;
        }
        return $products;
    }

    public function deleteProduct($id)
    {
        $query = "delete from products where id = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":userId", $id);
        if ($stmt->execute()) {
            header("Location: /my-profile");
        } else {
            echo $id;
            echo "something went wrong";
        }
    }

    public function getSingleProduct(int $id): array
    {
        $query = "select * from products where id = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":productId", $id);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }

    public function updateProduct($productId, $productName, $productQuantity, $productPrice)
    {
        try {
            $arr = ["name" => $productName, "quantity" => $productQuantity, "price" => $productPrice];
            $this->validate->validator($arr);
            $query = "update products
                  set name = :name, price = :price, quantity = :quantity
                  where id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":name", $productName);
            $stmt->bindValue(":id", $productId);
            $stmt->bindValue(":price", $productPrice);
            $stmt->bindValue(":quantity", $productQuantity);
            if ($stmt->execute()) {
                header("Location: /my-profile");
            } else {
                echo "something went wrong while updating";
            }
        } catch (CustomException $exception) {
            var_dump($exception->getTheError());
        }
    }

    public function reduceStock($productId, $purchasedQuantity)
    {
        try {
            $query = "update products
                      set quantity = quantity - :purchased_quantity
                      where id = :productId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":purchased_quantity", $purchasedQuantity);
            $stmt->bindValue(":productId", $productId);
            $stmt->execute();
            
        } catch(\Exception $exception) {
            echo("something went wrong while reducing stock".$exception->getMessage());
        }


    }

}
