<?php

use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();
$session->start();

if (!Session::checkLogin()) {
    header("Location: /login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        .cart-item {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .summary {
            font-size: 18px;
            margin-top: 30px;
            padding: 20px;
            border-top: 2px solid #333;
        }

        h1 {
            color: #333;
        }

        .pay-methods {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <a href="/logout">Logout</a>
    <h1>Checkout</h1>

    <?php if (!empty($cartItems)) : ?>
        <form action="/order" method="post">

            <label for="Address">Address: </label>
            <input type="text" name="address" required>

            <?php foreach ($cartItems as $index => $cartItem) : ?>
                <div class="cart-item">
                    <h2>Item <?= $index + 1 ?></h2>
                    <p><strong>Product:</strong> <?= htmlspecialchars($cartItem['name']) ?></p>
                    <p><strong>Price per Unit:</strong> $<?= htmlspecialchars($cartItem['price']) ?></p>
                    <p><strong>Quantity:</strong> <?= htmlspecialchars($cartItem['cartItemQuantity']) ?></p>
                    <p><strong>Type:</strong> <?= htmlspecialchars($cartItem['types']) ?></p>
                    <p><strong>Total:</strong> $<?= htmlspecialchars($cartItem['total']) ?></p>
                </div>
            <?php endforeach; ?>

            <div class="summary">
                <p><strong>Total Price:</strong> $<?= htmlspecialchars($totalPrice) ?></p>
                <p><strong>Tax:</strong> $<?= $tax ?></p>
                <p><strong>Grand Total:</strong> $<?= $grandTotal ?></p>

                <div class="pay-methods">
                    <strong>Available Payment Methods:</strong><br>
                    <?php foreach ($paymentMethods as $paymentmethod): ?>
                        <label>
                            <input type="radio" name="payment_method" value="<?= $paymentmethod ?>" required>
                            <?= strtoupper($paymentmethod) ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>

                <br>
                <button type="submit">Place Order</button>
            </div>
        </form>
    <?php else : ?>
        <p>No cart items to checkout.</p>
    <?php endif; ?>

    <br>
    <a href="/cart/<?php echo $cartId ?>">Back to Cart</a>
</body>

</html>