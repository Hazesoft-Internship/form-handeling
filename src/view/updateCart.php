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
echo $cartGrid->getCartUpdateForm();
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