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
    <title>Cart Item Detail</title>

</head>

<body>

    <div class="cart-item">
        <?php
        if (isset($cartItem)) {
            echo "<h2>" . htmlspecialchars($cartItem['product_name']) . "</h2>";
            echo "<p><strong>Product ID:</strong> " . htmlspecialchars($cartItem['product_id']) . "</p>";
            echo "<p><strong>Cart Item ID:</strong> " . htmlspecialchars($cartItem['cart_item_id']) . "</p>";
            echo "<p><strong>Price per Unit:</strong> $" . htmlspecialchars($cartItem['price']) . "</p>";
            echo "<p><strong>Quantity:</strong> " . htmlspecialchars($cartItem['quantity']) . "</p>";
            echo "<p><strong>Total Price:</strong> $" . htmlspecialchars($cartItem['total_price']) . "</p>";
            echo "<p><strong>Added to Cart:</strong> " . htmlspecialchars($cartItem['created_at']) . "</p>";
            echo "<p><strong>Last Updated:</strong> " . htmlspecialchars($cartItem['updated_at']) . "</p>";
        } else {
            echo "<p>Cart item not found.</p>";
        }
        ?>

        <a href="/cart/<?php echo $cartItem['cart_id'] ?>">All Carts</a>
    </div>

</body>

</html>