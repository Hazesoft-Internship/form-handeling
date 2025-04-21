<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order checkout</title>
    <link rel="stylesheet" href="../styles/global.css" />
</head>

<body>
    <h2>Checkout</h2>

    <h4>
        Address: <?= $address; ?>
    </h4>
    <form action="/order/checkout" method="POST">
        <div>
            Payment type:
            <select name="paymentType">
                <?php foreach ($paymentMethods as $key => $method): ?>
                    <option><?= $method ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <br>
        <br>
        <div class="cart-items">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Total Price after Tax</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $product): ?>
                        <tr>
                            <td>
                                <?= $product['product_name'] ?>
                            </td>
                            <td>
                                <?= $product['product_price'] ?>
                            </td>
                            <td>
                                <?= $product['added_quantity'] ?>
                            </td>
                            <td>
                                <?= $product['item_total_price'] ?>
                            </td>
                            <td>
                                <?= round($product['item_grand_total'], 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="5">
                            Grand total: <?= $totalPrice ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <input type="submit" name="orderSubmit" value="Submit">
        </div>
    </form>

</body>

</html>