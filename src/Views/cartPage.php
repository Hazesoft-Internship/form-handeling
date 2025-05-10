<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="/public/css/cartPage.css">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .cart-container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 32px 24px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 32px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th,
        td {
            padding: 16px 10px;
            text-align: center;
        }

        th {
            background: #f1f3f6;
            color: #222;
            font-weight: 600;
        }

        tr {
            border-bottom: 1px solid #eee;
        }

        tr:last-child {
            border-bottom: none;
        }

        .product-name {
            text-align: left;
        }

        input[type="number"] {
            width: 60px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }

        .total-row td {
            font-weight: bold;
            background: #f1f3f6;
        }

        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 6px 9px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
            display: block;
            margin: 0 auto;
        }

        button:hover {
            background: #0056b3;
        }

        @media (max-width: 600px) {
            .cart-container {
                padding: 10px;
            }

            th,
            td {
                padding: 8px 2px;
            }
        }
    </style>
</head>

<body>
    <div class="cart-container">
        <h1>Your Cart</h1>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($cartItems as $item):
                ?>
                    <tr>
                        <td class="product-name"><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <form method="post" action="/update-cart">
                                <input type="hidden" name="cart_item_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="product_quantity" value="<?php echo $item['product_quantity']; ?>">
                                <div style="display: flex; justify-content:space-evenly;margin-bottom:8px;">

                                    <input
                                        type="number"
                                        name="next_cart_quantity"
                                        value="<?php echo $item['cart_quantity']; ?>"
                                        min="1"
                                        max="<?php echo $item['product_quantity']; ?>" />
                                    <button type="submit">Update</button>
                                </div>
                            </form>
                        </td>
                        <td>$<?php echo number_format($item['cart_quantity'] * $item['price'], 2); ?></td>
                        <td>
                            <form method="post" action="/remove-from-cart">
                                <input type="hidden" name="cart_item_id" value="<?php echo $item['id']; ?>">
                                <button type="submit">Remove</button>
                            </form>
                        </td>

                    </tr>
                    <tr>
                        <td>

                            <span style="font-size: 1em; color: #888;">/ <?php echo $item['product_quantity']; ?> in stock</span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>

                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td>$<?php echo number_format($total, 2); ?></td>
                    <td>
                        <button onclick="window.location.href='/checkout'">Checkout</button>
                    </td>
                </tr>
            </tfoot>
        </table>
        <span style="font-size: 1em; color: #888;">Change the quantity and click update to update the quantity.</span>
    </div>
</body>

</html>