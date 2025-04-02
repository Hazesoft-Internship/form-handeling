<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require '../config.php';

use ayushtamang\FormHandeling\view\ProductGrid;
use ayushtamang\FormHandeling\model\Product;
use ayushtamang\FormHandeling\session\Session;

$session = Session::getSession("userLoggedIn");

if (!isset($session)) {
    header("Location: login.php");
    exit();
}

$productGrid = new ProductGrid($con);
echo $productGrid->updateProduct();

$update = new Product($con);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = Session::getSession("userId");
    $productName = $_POST["productname"];
    $productPrice =$_POST["productprice"];
    $productQuantity = $_POST["productquantity"];
    $id = Session::getSession("productId");

    if($update->updateProduct($userId, $productName, $productPrice, $productQuantity, $id)) {
        header("Location: productProfile.php");
    } else {
        echo "Failed to update product!";
    }
}

?>

<script>
    function onUpdate(e)
    {
        if (!confirm("Do you want to update?")) {
            e.preventDefault();
        }
    }

    function onDelete(e)
    {
        if (!confirm("Do you want to delete?")) {
            e.preventDefault();
        }
    }
</script>