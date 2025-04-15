<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
    <h2>Your Products</h2>
    <ul>
        <?php foreach ($products as $product): ?>
            <li><?= htmlspecialchars($product['product_name']) ?> - $<?= $product['price'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
