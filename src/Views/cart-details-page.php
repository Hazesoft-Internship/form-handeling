<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Details</title>
    <link rel="stylesheet" href="../styles/global.css" />
</head>

<body>
    <header>
        <div class="nav">
            <h1>
                Cart Details
            </h1>
            <nav>
                <ul class="nav-elements">
                    <li class="nav">
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="/products/create">Add Product</a>
                    </li>
                    <li>
                        <a href="/products">Products</a>
                    </li>
                    <li>
                        <form action="/logout" method="POST">
                            <button type="submit" name="logout" style="background: none; border: none; font: inherit; padding-top: 5px; color: purple; text-decoration: none;
cursor: pointer; font-size: large">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div>
        <h3>Cart Items</h3>
    </div>
    <div class="cart-items">
        <?php foreach ($cartItems as $product): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
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
                    </tr>
                    <tr>
                        <td colspan="4">
                            <form action="/cart/delete" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this product from cart?');" style="background:none; border:none; color:blue; text-decoration:none; cursor:pointer; padding:0; font:inherit;">
                                    Delete
                                </button>
                            </form>
                        </td>
                        <td colspan="4">
                            <form action="/cart/update" method="GET">
                                <input type="hidden" name="id" value="<?= $product['product_id'] ?>">
                                <button type="submit" style="background:none; border:none; color:blue; text-decoration:none; cursor:pointer; padding:0; font:inherit;">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
        <?php endforeach; ?>
    </div>
    <div>
        <h3>Total Price: Rs <?= $totalPrice ?></h3>
        <a href="/order/checkout">Proceed to checkout</a>
        </div>
    </div>
</body>

</html>