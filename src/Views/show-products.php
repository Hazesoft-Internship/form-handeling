<?php

use Hazesoft\Backend\Models\Product;
use Hazesoft\Backend\Services\Session;

// Initialize session
$session = Session::getInstance();
if (!$session->hasSession("isLoggedIn")) {
    header("Location: /");
    exit("Authentication failed");
}

$productObject = new Product();

$userId = $session->getSession("userId");
$myProducts = $productObject->getUserProducts($userId);

$otherProducts = $productObject->getOtherProducts($userId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Products</title>
    <link rel="stylesheet" href="../styles/global.css"/>
</head>

<body>
<header>
    <div class="nav">
        <h1>
            Products
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
    <h3>My Products</h3>
</div>
<div class="products">
    <?php foreach ($myProducts as $product): ?>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <?= $product['name'] ?>
                </td>
                <td>
                    <?= $product['price'] ?>
                </td>
                <td>
                    <?= $product['quantity'] ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <form action="/products/delete" method="POST">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this product?');" style="background:none; border:none; color:blue; text-decoration:none; cursor:pointer; padding:0; font:inherit;">
                            Delete
                        </button>
                    </form>
                </td>
                <td colspan="3">
                    <form action="/products/update" method="GET">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
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
<hr>
<div>
    <h3>Products</h3>
</div>
<div class="products">
    <?php foreach ($otherProducts as $product): ?>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <?= $product['name'] ?>
                </td>
                <td>
                    <?= $product['price'] ?>
                </td>
                <td>
                    <?= $product['quantity'] ?>
                </td>
            </tr>
            </tbody>
        </table>
        <br>
    <?php endforeach; ?>
</div>
</body>

</html>