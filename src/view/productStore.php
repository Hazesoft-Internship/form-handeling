<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require '../config.php';

use ayushtamang\FormHandeling\view\ProductGrid;
use ayushtamang\FormHandeling\session\Session;

$productGrid = new ProductGrid($con);
echo $productGrid->create();

$session = Session::getSession("userLoggedIn");

if (isset($session)) {
    echo "<a href='addProduct.php'>Add Product</a>
        <a href='../control/logout.php'>LogOut</a>
        <a href='productProfile.php'>Profile</a>";
} else {
    echo "<a href='../control/logout.php'>LogIn</a>";
}
?>