<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h2>Checkout Form</h2>
    <form action="/checkout" method="POST">
        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea><br><br>


        <label for="payment">Payment Method:</label>
        <select id="payment" name="payment" required>
            <?php foreach ($paymentTypes as $option): ?>
                <option value="<?php echo $option; ?>"> <?php echo $option; ?> </option>
            <?php endforeach; ?>
        </select><br><br>

        <h2>Cart Details</h2>
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>

                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Types</th>
                        <th>Subtotal</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>

                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['description']); ?></td>
                            <td><?php echo number_format($item['price'], decimals: 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo htmlspecialchars($item['productTypes']); ?></td>
                            <td><?php echo number_format($item['price'] * $item['quantity'], decimals: 2); ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
            // Calculate total price
            ?>
            <p><strong>Total Price:</strong> RS <?php echo number_format($totalPrice, 2); ?></p>
        <?php endif; ?>
        <br><br>


        <button type="submit">Submit</button>
    </form>
    <a href="/dashboard" style="display: inline-block; margin-top: 20px; padding: 10px 15px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">Go to Dashboard</a>
</body>

</html>