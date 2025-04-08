<?php


use Lattefront\FormHandeling\session\Session;

// Check if the user is logged in, 
$session = Session::getInstance();

if (!($session->isLoggedIn())) {
    header("Location: /login");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Add Form</title>
</head>

<body>
    <h1>Add New Product</h1>
    <form action="/addproduct" method="post">
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

        <button type="submit">Add Product</button>
        <input type="reset" value="Reset">
    </form>
</body>

</html>
</body>