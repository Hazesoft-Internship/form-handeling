<?php
session_start();
if (!isset($_SESSION['LoggedIn'])) {
    header("Location: /");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .product-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-form h1 {
            margin-bottom: 20px;
        }

        .product-form input {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .product-form input[type="submit"] {
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
        }

        .logout-form {
            margin-top: 20px;
        }

        .logout-form input[type="submit"] {
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="product-form">
        <h1>Product Store</h1>
        <form action="../controllers/ProductController.php" method="post">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" required><br><br>

            <label for="productPrice">Product Price:</label>
            <input type="number" id="productPrice" name="productPrice" step="0.01" required><br><br>

            <label for="productQuantity">Product Quantity:</label>
            <input type="number" id="productQuantity" name="productQuantity" required><br><br>

            <input type="submit" name="product-submit" value="Submit">
        </form>
        <form action="../controllers/UserController.php" method="post" class="logout-form">
            <input type="submit" name="logout" value="Logout">
        </form>
    </div>
</body>

</html>