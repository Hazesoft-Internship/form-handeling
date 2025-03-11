<?php

namespace formhandeling\controllers;

use formhandeling\models\User;

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../models/users.php';

class Product
{
    private $users;

    public function __construct()
    {
        $this->users = new User();
    }

    public function handleRequest(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $product_name = $_POST["name"];
            $product_quantity = $_POST["quantity"];
            $product_price = $_POST["price"];

            $product = $this->users->addproduct($product_name, $product_quantity, $product_price);
            if ($product) {
                header("Location: ../views/products.php");
                exit();
            } else {
                echo "Product not added";
            }
        }
    }
}

$product = new Product();
$product->handleRequest();
