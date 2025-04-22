<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Order</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        h2,
        h3 {
            text-align: center;
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>

    <h2>Order Details</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($orderItems) && is_array($orderItems)):
                $i = 1;
                $grandTotal = 0;
                foreach ($orderItems as $item):
                    $grandTotal += (float)$item['total_price'];
            ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rs <?= number_format($item['unit_price'], 2) ?></td>
                        <td>Rs <?= number_format($item['total_price'], 2) ?></td>
                    </tr>
                <?php
                endforeach;
            else:
                ?>
                <tr>
                    <td colspan="6">No order items found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="/products">Back to Products</a>


</body>

</html>