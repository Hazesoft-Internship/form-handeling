<?php

use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();

$session->start();

if (!Session::checkLogin()) {
    header("Location: /products");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cart Item Detail</title>

</head>

<body>

    <div class="cart-item">
        <?php
        if (isset($cartItem)) {
            echo "<h2>" . htmlspecialchars($cartItem['product_name']) . "</h2>";
            echo "<p><strong>Price per Unit:</strong> $" . htmlspecialchars($cartItem['price']) . "</p>";
            echo "<p><strong>Quantity:</strong> " . htmlspecialchars($cartItem['quantity']) . "</p>";
            echo "<p><strong>Total Price:</strong> $" . htmlspecialchars($cartItem['total_price']) . "</p>";
            echo "<p><strong>Added to Cart:</strong> " . htmlspecialchars($cartItem['created_at']) . "</p>";
            echo "<p><strong>Last Updated:</strong> " . htmlspecialchars($cartItem['updated_at']) . "</p>";
        } else {
            echo "<p>Cart item not found.</p>";
        }
        ?>
    </div>

</body>
<script>
    const showQuantityBtn = document.getElementById('showQuantityBtn');
    const cartForm = document.getElementById('cartForm');
    showQuantityBtn.addEventListener('click', function() {
        cartForm.style.display = 'block';
        showQuantityBtn.style.display = 'none';
    });
</script>

</html>