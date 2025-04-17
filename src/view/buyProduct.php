<?php

namespace ayushtamang\FormHandeling\view;

use ayushtamang\FormHandeling\session\Session;
use ayushtamang\FormHandeling\database\Database;
use ayushtamang\FormHandeling\controls\product_controls\ProductGrid;

$db = Database::getInstance();
$con = $db->getConnection();

$session = Session::getInstance();
$user = $session->getSession("userLoggedIn");

if (!isset($user)) {
    header("Location: /login");
    exit();
}

$productGrid = new ProductGrid($con);
echo $productGrid->getBuyProduct();
?>