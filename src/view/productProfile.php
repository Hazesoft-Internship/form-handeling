<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require "../config.php";

use ayushtamang\FormHandeling\view\ProductGrid;
use ayushtamang\FormHandeling\model\Product;
use ayushtamang\FormHandeling\session\Session;

$session = Session::getSession("userLoggedIn");

if (!isset($session)) {
    header("Location: login.php");
    exit();
}

$productGrid = new ProductGrid($con);
echo $productGrid->getProductsByUserId();

$delete = new Product($con);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = Session::getSession("productId");
    // dd($id);

    if($delete->deleteProduct($id)) {
        header("Location: productProfile.php");
    } else {
        echo "Failed to delete product!";
    }
}
?>