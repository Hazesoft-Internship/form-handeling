<!DOCTYPE html>
<html>
<head>
    <title>All Products</title>
</head>
<body>
    <h2>All Products</h2>
    <a href="/cart">View Cart</a>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?= htmlspecialchars($product['product_name']) ?> -
                $<?= $product['price'] ?> (Stock: <?= $product['quantity'] ?>)
                <form method="POST" action="/cart/add">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>