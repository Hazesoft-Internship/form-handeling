<?php

use ECommerce\Controllers\ProductController\ProductController;
use ECommerce\Services\Session;

$session = Session::getInstance();
$product = new ProductController();
$productID = isset($_GET['id']) ? $_GET['id'] : null;

$productByID = $product->getProductByID($productID);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
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
            cursor: pointer;
        }

        .product-form input[type="submit"]:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            opacity: 0.5;
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

        <h1>Update Product</h1>
        <form action="/update-product-submit?id=<?php echo htmlspecialchars($productID) ?>" method="post">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" value=<?php echo $productByID['name'] ?>><br><br>

            <label for="productPrice">Product Price:</label>
            <input type="number" id="productPrice" name="productPrice" step="0.01" value=<?php echo $productByID['price'] ?>><br><br>

            <label for="productQuantity">Product Quantity:</label>
            <input type="number" id="productQuantity" name="productQuantity" value=<?php echo $productByID['quantity'] ?>><br><br>

            <input type="submit" id="button-update" name="product-update" value="Update" disabled>
        </form>

        <form action="/logout-submit" onclick="return confirm('Are you sure?');" method="post" class="logout-form">
            <input type="submit" name="logout" value="Logout">
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productName = document.getElementById("productName");
            const productPrice = document.getElementById("productPrice");
            const productQuantity = document.getElementById("productQuantity");
            const updateButton = document.getElementById("button-update");

            const checkInputs = () => {
                if (productName.value.trim() !== "" || productPrice.value.trim() !== "" || productQuantity.value.trim() !== "") {
                    updateButton.disabled = false;
                } else {
                    updateButton.disabled = true;
                }
            };

            productName.addEventListener("input", checkInputs);
            productPrice.addEventListener("input", checkInputs);
            productQuantity.addEventListener("input", checkInputs);

            checkInputs();
        });
    </script>
</body>

</html>