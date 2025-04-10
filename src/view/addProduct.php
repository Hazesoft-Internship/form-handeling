<?php

use ayushtamang\FormHandeling\session\Session;

$session = Session::getInstance();
$user = $session->getSession("userLoggedIn");

if (!isset($user)) {
    header("Location: /login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>
<body>
    <form action="/product/addSubmit" method="POST">
        <label>Product Name</label>
        <input type="text" name="productname" placeholder="Product Name" autocomplete="off" required>
        <br>
        <label>Product Price</label>
        <input type="number" name="productprice" placeholder="Product Price" autocomplete="off" required>
        <br>
        <label>Product Quantity</label>
        <input type="number" name="productquantity" placeholder="Product Quantity" autocomplete="off" required>
        <br>
        <button type="submit" name="submitButton" value="SUBMIT">Add Product</button>
    </form>
    <a href="/product">Back</a>
</body>
</html>

