<?php

namespace ayushtamang\FormHandeling\view;

use ayushtamang\FormHandeling\session\Session;
use ayushtamang\FormHandeling\database\Database;
use ayushtamang\FormHandeling\controls\cart_controls\CartGrid;

$db = Database::getInstance();
$con = $db->getConnection();

$session = Session::getInstance();
$user = $session->getSession("userLoggedIn");

if (!isset($user)) {
    header("Location: /login");
    exit();
}

$cartGrid = new CartGrid($con);
echo $cartGrid->getCartsOfUser();
?>