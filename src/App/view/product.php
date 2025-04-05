<?php

use App\format\DateTimeFormatter;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
</head>

<body>
    <div class="product">
        <h1 class="heading">Product List</h1>
        <?php if (!empty($storeProduct)): ?>
            <div class="container">
                <?php foreach ($storeProduct as $product): ?>
                    <div class="products">
                        <strong>Name:</strong> <?php echo $product['name']; ?>
                        <strong>Quantity:</strong> <?php echo $product['quantity']; ?>
                        <strong>Price:</strong> $<?php echo $product['price']; ?>
                        <strong>added on:</strong> <?php echo DateTimeFormatter::formatDateTime($product['created_at']); ?>
                        <strong>Last updated on:</strong> <?php echo DateTimeFormatter::formatDateTime($product['updated_at']); ?>
                    </div>
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