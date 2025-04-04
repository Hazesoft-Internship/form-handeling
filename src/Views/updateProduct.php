<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="product-container">
        <?php

        use App\Controllers\ProductController;

        $products = (new ProductController())->listProducts();
        if (empty($products)) {
            echo "No products found.";
            return;
        }
        foreach ($products as $product): ?>
            <div class="product-card">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                <p>Quantity: <?php echo htmlspecialchars($product['quantity']); ?></p>
                <form action="/product/update" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                    <input type="text" name="description" value="<?php echo htmlspecialchars($product['description']); ?>">
                    <input type="number" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
                    <input type="number" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>">
                    <button type="submit">Update</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>