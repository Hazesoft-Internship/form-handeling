<?php

use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();

$session->start();

if (!Session::checkLogin()) {
    header("Location: /login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Products</title>
</head>

<body>
    <a href="/logout">Logout</a>
    <hr>

    <h2>Available Products</h2>

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

        <a href="/cart/<?php echo $cartId ?>">View cart</a>
        <a href="/my_products">My Products</a>
    </div>
</body>

</html>