<?php

use ayushtamang\FormHandeling\controls\product_controls\ProductGrid;
use ayushtamang\FormHandeling\session\Session;
use ayushtamang\FormHandeling\database\Database;

$db = Database::getInstance();
$con = $db->getConnection();

$productGrid = new ProductGrid($con);
echo $productGrid->create();

$session = Session::getInstance();
$user = $session->getSession("userLoggedIn");

if (isset($user)) {
    echo "<a href='/product/add'>Add Product</a>
        <a href='/logout'>LogOut</a>
        <a href='/product/profile'>Profile</a>";
} else {
    echo "<a href='/login'>LogIn</a>";
}

echo "<br><a href='api.php'>Check PRoduct API</a>";
?>