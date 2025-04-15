<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product to Cart</title>
</head>

<body>
    <h1>Insert product to cart</h1>
    <div>
        <form action="/cart/insert" method="POST">
            <input type="hidden" name="productId" value="<?= $productId ?>">
            <label for="name">
                Name: <?= $product['name'] ?>
            </label>
            <br>
            <label for="price">
                Price: <?= $product['price'] ?>
            </label>
            <br>
            <label for="quantity">
                Quantity:
            </label>
            <input type="number" name="quantity" min="1" max="<?= isset($product['quantity']) ? $product['quantity'] : 100000 ?>" value="<?= isset($cart['quantity']) ? $cart['quantity'] : 1 ?>" required>
            <br>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
</body>

</html>