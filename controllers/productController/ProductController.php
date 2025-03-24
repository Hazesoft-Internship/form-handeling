<?php

require_once '../models/Product.php';

$product = new Product();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["product-submit"])) {
        $productName = $_POST["productName"];
        $productPrice = $_POST["productPrice"];
        $productQuantity = $_POST["productQuantity"];

        $product->addProduct($productName, $productPrice, $productQuantity);
    }
}
