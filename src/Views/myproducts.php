<?php

error_reporting(E_ALL);
// ini_set('display_errors', 1);



use App\Controllers\ProductController;



$products = (new ProductController())->userProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Products</title>

    <style>
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .product-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            background-color: #f9f9f9;
        }

        .product-card form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .product-card label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .product-card input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .product-card button {
            margin-top: 5px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .product-card button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Your Products</h1>
    <a href="/addproduct" style="text-align: center; display: block; margin-bottom: 20px;">Add New Product</a>
    <div class="product-container">
        <?php if (empty($products)): ?>
            <p>No products found.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <form action="/product/update" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['product_id']) ?>" />
                        <label for="name">Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" />
                        <label for="description">Description</label>
                        <input type="text" name="description" value="<?= htmlspecialchars($product['description']) ?>" />
                        <label for="price">Price</label>
                        <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" />
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" />
                        <button type="submit">Update</button>
                    </form>

                    <form action="/product/delete" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['product_id']) ?>" />
                        <button type="submit">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>