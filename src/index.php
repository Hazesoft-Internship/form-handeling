<?php
// require_once(__DIR__ . 'src/Config/SessionHandler.php');
require(__DIR__ . '/../vendor/autoload.php');

use Hazesoft\Backend\Config\SessionHandler;
use Hazesoft\Backend\Models\Product;


$session = new SessionHandler();
$productObject = new Product();

$isLoggedIn = $session->getSession("isLoggedIn");
$userId = $session->getSession("userId");

$allProducts = $productObject->getAllProducts();
$myProducts = $productObject->getUserProducts($userId);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xStore</title>
    <link rel="stylesheet" href="styles/global.css" />
</head>

<body>
    <div class="nav">

        <h1>Welcome to xStore<?php

                                if ($session->hasSession("isLoggedIn")) {
                                    echo ", {$session->getSession("firstName")}";
                                }

                                echo '
</h1>
        <nav>
            <ul class="nav-elements">
                <li class="nav">
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="Views/showproducts.php">Products</a>
                </li>
                                ';

                                if ($session->hasSession("isLoggedIn") == false) {
                                    echo '<li>
                <a href="Views/login.html">Sign In</a>
            </li>
            <li>
                <a href="Views/signup.html">Sign Up</a>
            </li> ';
                                } else {
                                    echo '
            <li>
                <a href="Controllers/Logout.php" onclick="return confirm("Are you sure you want to Logout?");" >Logout</a>
            </li> 
                ';
                                }
                                ?>
            </ul>
            </nav>
    </div>

    <?php if ($isLoggedIn) : ?>
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

    <?php else: ?>
        <div>
            <h3>All Products</h3>
        </div>
        <div class="products">
            <?php foreach ($allProducts as $product): ?>
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
    <?php endif; ?>
</body>

</html>