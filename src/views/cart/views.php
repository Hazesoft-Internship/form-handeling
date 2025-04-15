<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
</head>
<body>
    <h2>Your Cart</h2>
    <form method="POST" action="/cart/update">
        <?php foreach ($items as $item): ?>
            <div>
                <?= htmlspecialchars($item['product_name']) ?> -
                $<?= $item['price'] ?> each
                <input type="number" 
                       name="quantity[<?= $item['product_id'] ?>]" 
                       value="<?= $item['quantity'] ?>"
                       min="1" 
                       max="<?= $item['stock'] ?>">
            </div>
        <?php endforeach; ?>
        <button type="submit">Update Cart</button>
    </form>
    <p>Total: $<?= array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $items)) ?></p>
    <a href="/products/all">Continue Shopping</a>
</body>
</html>