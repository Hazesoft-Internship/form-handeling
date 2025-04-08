<?php

use App\Controllers\ProductController;

$products = (new ProductController())->listProducts();

if (empty($products)) {
    echo "No products found.";
    return;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .product-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 200px;
            height: 150px;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .product-card h2 {
            font-size: 1.5em;
            margin-bottom: 8px;
        }

        .product-card p {
            margin: 8px 0;
            color: #555;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;

        }
    </style>
    <h1><a href="








































    /myproducts">Click here to view your Products</a></h1>
    <h1>Product List</h1>
    <div class="product-container">
        <?php
        foreach ($products as $product) {
            echo "<div class='product-card'>";
            echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
            echo "<p>" . htmlspecialchars($product['description']) . "</p>";
            echo "<p>Price: $" . htmlspecialchars($product['price']) . "</p>";
            echo "<p>Quantity: " . htmlspecialchars($product['quantity']) . "</p>";

            echo "</div>";
        }
        ?>
    </div>
</body>

</html>