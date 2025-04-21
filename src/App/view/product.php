
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
    <link href="/product.css" rel="stylesheet" />
</head>

<body>
    <h1 class="heading">Product List</h1>
    <a href="/cart"><button class="cart">view cart</button></a>
    <?php if (!empty($formattedProduct)): ?>
        <div class="container">
            <?php foreach ($formattedProduct as $product): ?>
                <div class="products">
                    <strong>Name:</strong> <?php echo $product['name']; ?>
                    <strong>Quantity:</strong> <?php echo $product['quantity']; ?>
                    <strong>Price:</strong> $<?php echo $product['price']; ?>
                    <strong>added on:</strong> <?php echo $product['created_at']; ?>
                    <strong>Last updated on:</strong> <?php echo $product['updated_at']; ?>
                </div>
                <?php if (!$getSession || $product["user_id"] === $getSession): ?>
                <?php else: ?>
                    <form method="POST" action="/cart">
                        <input type="hidden" name="productId" value=<?php echo $product['id'] ?> />
                        <button type="submit">add to cart</button>
                    </form>

                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No products available.</p>
    <?php endif; ?>
    <?php if ($hasSession): ?>
        <div class="button">
            <a href="/my-profile"><button>my product</button></a>
        </div>
    <?php endif; ?>

    <?php if ($hasSession): ?>
        <div class="button">
            <form action="/logout" method="POST">
                <button>logout</button>
            </form>
        </div>
    <?php else: ?>
        <div>
            <a href="/login"><button>login</button></a>
        </div>
    <?php endif; ?>
</body>
<script>
    const onSubmit = (e) => {
        if (!confirm("Do you really want to delete?")) {
            e.preventDefault();
        }
    }
</script>

</html>