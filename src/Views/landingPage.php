<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        .auth-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .auth-buttons button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .auth-buttons button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <h1><a href="/my-products">Click here to view your Products</a></h1>
    <h1><a href="/home">Home</a></h1>
    <button onclick="window.location.href='/cart'">View Cart</button>
    <?php
    if (!$loggedIn) {

        echo " <div class='auth-buttons'>";
        echo " <button onclick=window.location.href='/login'>Login</button>";
        echo " <button onclick=window.location.href='/signup'>Sign Up</button>";
        echo " </div>";
    } else {
        echo " <div class='auth-buttons'>";
        echo "<form method='POST' action='/logout'>";
        echo " <button type='submit'>Logout</button>";
        echo "</form>";
        echo " </div>";
    }

    ?>
    <h1>Product List</h1>
    <div class="product-container">
        <?php
        if (empty($products)) {
            echo "<h1>No products found.";
        }
        foreach ($products as $product) {
            echo "<div class='product-card'>";
            echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
            echo "<p>" . htmlspecialchars($product['description']) . "</p>";
            echo "<p>Price: $" . htmlspecialchars($product['price']) . "</p>";
            echo "<p>Quantity: " . htmlspecialchars($product['quantity']) . "</p>";
            echo "<form method='POST' action='/cart'>";
            echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($product['product_id']) . "'>";
            echo " <button type='submit'>Add to Cart</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>
</body>

</html>