<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
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
    <h1>Your Shopping Cart</h1>

    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Types</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>

                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['description']); ?></td>
                        <td><?php echo number_format($item['price'], decimals: 2); ?></td>
                        <td><?php echo htmlspecialchars($item['productTypes']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'] * $item['quantity'], decimals: 2); ?></td>
                        <td>
                            <form action="/deletecart" method="POST" style="display: inline;">
                                <input type="hidden" name="productID" value="<?php echo htmlspecialchars((string) ($item['productID'] ?? '')); ?>">
                                <button type="submit">Remove</button>
                            </form>

                            <form action="/updatecart" method="GET" style="display: inline;">
                                <input type="hidden" name="cartitemsId" value="<?php echo htmlspecialchars((string) ($item['cart_item_id'] ?? '')); ?>">
                                <input type="hidden" name="productID" value="<?php echo htmlspecialchars((string) ($item['productID'] ?? '')); ?>">
                                <input type="hidden" name="quantity" value="<?php echo htmlspecialchars((string) ($item['quantity'])); ?>">
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
       
        <p><strong>Total Price:</strong> RS <?php echo number_format($totalPrice, 2); ?></p>
    <?php endif; ?>

    <a href="/" style="display: inline-block; padding: 10px 15px; background-color:rgb(163, 91, 14); color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">Continue Shopping</a>

    <a href="/dashboard" style="display: inline-block; padding: 10px 15px; background-color:rgb(26, 129, 213); color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">Dashboard</a>
    
    <a href="/checkout" style="display: inline-block; padding: 10px 15px; background-color:rgb(5, 128, 40); color: white; text-decoration: none; border-radius: 5px;">Checkout</a>
</body>

</html>