<?php

use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Module\Product;

$viewproduct = new Product(new DbConnection());
$row = $viewproduct->viewallProducts();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALL Products</title>
</head>

<body>
    <div class="container">
        <h1 style="text-align: center;"> ALL Products</h1>
        <a href="/dashboard" class="btn">Dashboard</a>
        <div class="product">
            <?php foreach ($row as $product) : ?>
                <h2>Product Name: <?php echo htmlspecialchars($product['productName']); ?></h2>
                <p><strong>Price:</strong> Rs <?php echo number_format($product['price'], 2); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($product['quantity']); ?></p>
                <p><strong>Product ID:</strong> <?php echo htmlspecialchars($product['productID']); ?></p>

            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>