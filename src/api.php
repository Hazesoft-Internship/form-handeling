<?php

header('Content-Type: application/json');

$con = new PDO("mysql:host=localhost;dbname=haze", 'root', '');
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = $con->prepare("SELECT * FROM products");
$query->execute();

$products = array();

foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $product = array(
        "id" => $row['id'],
        "userId" => $row['userId'],
        "productName" => $row['productName'],
        "productPrice" => $row['productPrice'],
        "productQuantity" => $row['productQuantity'],
        "createdAt" => $row['createdAt'],
        "updatedAt" => $row['updatedAt'],
    );
    array_push($products, $product);
}

$encodedProducts = json_encode($products, JSON_PRETTY_PRINT);
file_put_contents(__DIR__ . "/products.json", $encodedProducts);
echo $encodedProducts;
?>