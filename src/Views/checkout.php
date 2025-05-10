<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .checkout-container {
            max-width: 900px;
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

        .total-row td {
            font-weight: bold;
            background: #f1f3f6;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 12px 32px;
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
            .checkout-container {
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
    <div class="checkout-container">
        <h1>Checkout</h1>

        <?php
        if ($cartItems == null) {
            echo "<h1>Cart Empty</h1>";
            echo "<a href='/cart'> view cart</a>";
            die();
        }

        ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>shipping</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php


                foreach ($newCartItems as $item):

                ?>
                    <tr>
                        <td class="product-name"><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['type']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['cart_quantity']; ?></td>
                        <td>$<?php echo number_format($item['discount'], 2); ?></td>
                        <td>$<?php echo number_format($item['shipping'], 2); ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['cart_quantity'] - $discount + $shipping, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">Order:</td>
                    <td>$<?php echo number_format($totalOrder, 2); ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">Tax:</td>
                    <td>$<?php echo number_format($this->orderDetail['tax'], 2); ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">Discount:</td>
                    <td>$<?php echo number_format($this->orderDetail['discount']); ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">shipping:</td>
                    <td>$<?php echo number_format($this->orderDetail['shipping']); ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">Grand Total:</td>
                    <td>$<?php echo number_format($this->orderDetail['grandTotal'], 2); ?></td>
                </tr>
            </tfoot>
        </table>
        <form action="/order" method="post">
            <label for="Address">Address</label>
            <input type="text" name="address" id="Address" required>
            <label for="payment">Payment</label>
            <select name="payment" id="payment" required>
                <?php foreach ($payment_method as $method): ?>
                    <option value="<?php echo htmlspecialchars($method); ?>"><?php echo htmlspecialchars($method); ?></option>
                <?php endforeach ?>
            </select>
            <button type="submit">Buy now</button>
        </form>
    </div>
</body>

</html>