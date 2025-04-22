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
    <title>My Cart Items</title>
</head>

<body>
    <a href="/logout">Logout</a>

    <h1>My Cart Items</h1>

    <?php if (!empty($cartItems)) : ?>
        <form action="/cart/update-all" method="post">
            <?php foreach ($cartItems as $index => $cartItem) : ?>
                <div id="cart-item-<?= $cartItem['id'] ?>" class="cart-item">
                    <hr>
                    <h2>Item <?= $index + 1 ?></h2>
                    <p><strong>Product:</strong>
                        <a href="/product/<?= $cartItem['product_id'] ?>">
                            <?= htmlspecialchars($cartItem['name']) ?>
                        </a>
                    </p>
                    <p><strong>Price per Unit:</strong> $<?= htmlspecialchars($cartItem['price']) ?></p>
                    <p><strong>Total Price:</strong> $<?= htmlspecialchars($cartItem['total']) ?></p>
                    <p><strong>Type:</strong><?= htmlspecialchars($cartItem['types']) ?></p>

                    <p><strong>Quantity:</strong>
                        <button type="button" onclick="decreaseQuantity(<?= $cartItem['id'] ?>)">-</button>
                        <span id="qty-<?= $cartItem['id'] ?>"><?= htmlspecialchars($cartItem['cartItemQuantity']) ?></span>
                        <button type="button" onclick="increaseQuantity(<?= $cartItem['id'] ?>, <?= $cartItem['productQuantity'] ?>)">+</button>
                        <input type="hidden" name="quantity[<?= $cartItem['id'] ?>]" id="input-<?= $cartItem['id'] ?>" value="<?= $cartItem['cartItemQuantity'] ?>">
                    </p>

                    <button type="button" onclick="deleteItem(<?= $cartItem['id'] ?>)">Delete</button>
                </div>
            <?php endforeach; ?>

            <hr>
            <button type="submit">Update All</button>
        </form>
    <?php else : ?>
        <p>No cart items available.</p>
    <?php endif; ?>
    <p><strong>Total Price:</strong><?= htmlspecialchars($totalPrice) ?></p> <a href="/checkout">Checkout</a>
    <br>
    <a href="/products">Back to Products</a>




    <script>
        function increaseQuantity(id, max) {
            const span = document.getElementById('qty-' + id);
            const input = document.getElementById('input-' + id);
            let value = parseInt(span.innerText);
            if (value < max) {
                value++;
                span.innerText = value;
                input.value = value;
            }
        }

        function decreaseQuantity(id) {
            const span = document.getElementById('qty-' + id);
            const input = document.getElementById('input-' + id);
            let value = parseInt(span.innerText);
            if (value > 1) {
                value--;
                span.innerText = value;
                input.value = value;
            }
        }

        function deleteItem(cartItemId) {
            if (!confirm("Are you sure you want to delete this item?")) return;

            // Send DELETE request using fetch API
            fetch("/cart/delete", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `cart_item_id=${cartItemId}`
                })
                .then(response => {
                    if (response.ok) {
                        // Option 1: Reload the page to reflect the changes
                        location.reload();

                        // Option 2 (optional): Remove the item from the DOM without reload
                        // document.getElementById(`cart-item-${cartItemId}`).remove();
                    } else {
                        alert("Failed to delete the item.");
                    }
                })
                .catch(error => {
                    console.error("Error deleting item:", error);
                });
        }
    </script>
</body>

</html>