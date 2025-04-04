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
                <form action="/product/delete" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <button type="submit">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>