
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY Product</title>
</head>

<body>
    <div class="container">
        <h1 style="text-align: center;"> MY Products </h1>
        <a href="/dashboard" class="btn">Dashboard</a>
        <div class="product">
            <?php foreach ($row as $product) : ?>
                <h2>Product Name: <?php echo htmlspecialchars($product['productName']); ?></h2>
                <p><strong>Price:</strong> Rs <?php echo number_format($product['price'], 2); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($product['quantity']); ?></p>
                <p><strong>Product ID:</strong> <?php echo htmlspecialchars($product['productID']); ?></p>
                <p><strong>Product Type:</strong> <?php echo htmlspecialchars($product['productTypes']); ?></p>

                <form action="/updateproduct" method="GET" style="display: inline;">  
                    <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($product['productID']); ?>" readonly>
                    <input type="hidden" id="name" name="name" value="<?php echo htmlspecialchars($product['productName']); ?>" readonly>
                    <input type="hidden" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" readonly>
                    <input type="hidden" id="description" name="description" value="<?php echo htmlspecialchars($product['description']); ?>" readonly>
                    <input type="hidden" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" readonly>
                    <input type="hidden" id="productTypes" name="productTypes" value="<?php echo htmlspecialchars($product['productTypes']); ?>" readonly>
                    <button type="submit">Edit </button>
                </form>
                <form action="/deleteproduct" method="POST" style="display: inline;">  
                    <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($product['productID']); ?>" readonly>
                    <button type="submit">Delete</a></button>
                </form>

            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>