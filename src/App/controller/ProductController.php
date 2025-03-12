<?php

namespace App\controller;

// require_once("/src/App/model/Product.php");
use App\model\Product;

class ProductController
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addProduct()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo "something went wrong while adding product";
            return;
        } else {
            $name = $_POST["name"];
            $price = $_POST["price"];
            $quantity = $_POST["quantity"];
            $product = new Product($this->conn);
            $product->addProduct($name, $price, $quantity);
        }
    }
}
