<?php

namespace App\controller;

use App\model\Product;

class ProductController
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addProduct(string $name, int $price, int $quantity, int $userId)
    {
        echo $name, $price, $quantity;
        if (empty($name) || empty($price) || empty($quantity)) {
            echo "something went wrong while adding product";
            return;
        } else {
            $product = new Product($this->conn);
            $product->addProduct($name, $price, $quantity, $userId);
            header("Location: ../view/product.php");
        }
    }

    public function deleteProduct() {}
}
