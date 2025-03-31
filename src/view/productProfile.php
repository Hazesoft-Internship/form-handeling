<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require "../config.php";

use ayushtamang\FormHandeling\view\ProductGrid;

if (!isset($_SESSION["userLoggedIn"])) {
    header("Location: login.php");
    exit();
}

$productGrid = new ProductGrid($con);

echo $productGrid->getProductsByUserId();
?>