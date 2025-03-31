<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require_once("../config.php");

use ayushtamang\FormHandeling\model\UploadProduct;
use ayushtamang\FormHandeling\model\GetUserDetails;

if (!isset($_SESSION["userLoggedIn"])) {
    header("Location: login.php");
    exit();
}

$upload = new UploadProduct($con);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $ui = new GetUserDetails($con, $_SESSION["userLoggedIn"]);
    $pn = $_POST["productname"];
    $pp = $_POST["productprice"];
    $pq = $_POST["productquantity"];
    
    if($upload->addProduct($ui->getUserId(),  $pn, $pp, $pq)) {
        header("Location: productStore.php");
    } else {
        echo "Failed to add product!";
    }
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
    <form action="addProduct.php" method="POST">
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
    <a href="productStore.php">Back</a>
</body>
</html>

