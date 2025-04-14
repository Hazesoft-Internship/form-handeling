<?php

use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();

$session->start();

if (!Session::checkLogin()) {
    header("Location: login_form.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Products</title>
</head>

<body>

    <a href="/add_product">Add Product</a>
    <a href="/products">Others Products</a>
    <a href="/logout">Logout</a> 

    <h1>My Products</h1>
    <div class="product-list">
        <?php
        if (!empty($products)) {
            foreach ($products as $product) {
                echo "<h3><a href='/product/" . $product['productid'] . "'>" . htmlspecialchars($product['name']) . "</a></h3>";
            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>
</body>

</html>