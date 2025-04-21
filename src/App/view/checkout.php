
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart Items</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <form method="POST" action="/order">
        <label>address</label>
        <input name="address" type="text"/>
        <label>payment type</label>
        <select name="paymentMethod">
            <?php foreach($options as $option):?>
                <option value=<?php echo $option ?>><?php echo $option?></option>
                <?php endforeach;?>
        </select>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Product Price</th>
            <th>Quantity</th>
            <th>Purchase Quantity</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= htmlspecialchars($item['product_price']) ?></td>
                <td><?= htmlspecialchars($item['quantity']) ?></td>
                <td><?= htmlspecialchars($item['purchase_quantity']) ?></td>
                <td><?= htmlspecialchars($item['price']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<button type="submit">Submit</button>
    </form>
</body>
</html>
