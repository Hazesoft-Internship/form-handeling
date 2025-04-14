<?php

use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();

$session->start();

if (!Session::checkLogin()) {
    header("Location: login_form.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My cartItems</title>
</head>

<body>
    <a href="/logout">Logout</a>

    <h1>My Cart Items</h1>
    <div class="cartItem-list">

        <?php
        if (!empty($cartItems)) {
            foreach ($cartItems as $cartItem) {
                echo "<h3><a href='/cartitem/" . $cartItem['id'] . "'>" . htmlspecialchars($cartItem['name']) . "</a></h3>";
            }
        } else {
            echo "<p>No cartItems available.</p>";
        }
        ?>
        <a href="/products">Back to Products</a>
</body>

</html>