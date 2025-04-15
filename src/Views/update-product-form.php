<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>

<body>
<form action="/products/update" method="POST">
    <input type="hidden" name="id" value="<?= $productId ?>">
    <div class="input">
        <label for="name">
            Product name:
            <input type="text" name="productName" value="<?= $currentProduct['name'] ?>" required>
        </label>
    </div>
    <div class="input">
        <label for="price">
            Price:
            <input type="text" name="productPrice" value="<?= $currentProduct['price'] ?>" required>
        </label>
    </div>
    <div class="input">
        <label for="quantity">
            Quantity:
            <input type="text" name="productQuantity" value="<?= $currentProduct['quantity'] ?>" required>
        </label>
    </div>
    <div class="input">
        <input type="submit" name="submit" value="Submit">
    </div>
</form>
</body>

</html>