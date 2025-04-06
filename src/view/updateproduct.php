<?php

session_start();

// Check if the user is logged in, 
if (!isset($_SESSION['email'])) {
    header("Location: /login");
    exit();
}

// Get the product ID from the query string
// if (isset($_GET['id'])) {
//     $productId = $_GET['id'];
// } 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update Form</title>
</head>

<body>
    <h1>update Product</h1>
    <form action="/updateproduct" method="post">
        <label for="id">Product ID:</label>
        <!-- <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($productId); ?>" readonly> -->
        <input type="number" id="id" name="id" required>
        <br><br>

        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>
        <br><br>

        <label for="product_price">Price:</label>
        <input type="number" id="product_price" name="product_price" step="0.01" required>
        <br><br>

        <label for="product_description">Description:</label>
        <textarea id="product_description" name="product_description" rows="4" cols="50" required></textarea>
        <br><br>

        <label for="product_quantity">Quantity:</label>
        <input type="number" id="product_quantity" name="product_quantity" required>

        <br><br>

        <button type="submit">Update Product</button>
        <input type="reset" value="Reset">
    </form>
</body>

</html>
</body>