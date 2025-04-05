<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use Hazesoft\Backend\Models\Product;
use Hazesoft\Backend\Config\SessionHandler;

// Initialize session
$session = new SessionHandler();
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
    <link rel="stylesheet" href="../styles/global.css" />
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
                        <a href="product.html">Add Product</a>
                    </li>
                    <li>
                        <a href="../Controllers/Logout.php" onclick="return confirm('Are you sure you want to Logout?');">Logout</a>
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
                            <a href="../Controllers/deleteProduct.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                        <td colspan="3">
                            <a href="updateProduct.php?id=<?= $product['id'] ?>">Update</a>
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