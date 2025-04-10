<?php
// Assuming 'product' is passed to the view containing the current product details
// and 'errors' contains any validation errors if validation failed.

$product = $product ?? null;
$errors = $errors ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>

<body>
    <h1>Edit Product</h1>

    <!-- Display errors if there are any -->
    <?php if (!empty($errors)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errors); ?></p>
    <?php endif; ?>




    <!-- Product Update Form -->
    <form action="/product/<?php echo $product['productid'] ?>/update_product" method="POST">
        <!-- Hidden field for the product ID -->
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['productid']) ?>">

        <label for="name">Product Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>
        <br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity'] ?? '') ?>" required>
        <br><br>

        <label for="price">Price:</label>
        <input type="text" name="price" value="<?= htmlspecialchars($product['price'] ?? '') ?>" required>
        <br><br>

        <button type="submit">Update Product</button>
    </form>

    <br>
    <a href="/product/<?php echo $product['productid'] ?>">Back to Product Details</a>
</body>

</html>