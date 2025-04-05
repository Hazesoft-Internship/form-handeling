<?php

namespace Hazesoft\Backend\Controllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Hazesoft\Backend\Models\Product;
use Hazesoft\Backend\Config\SessionHandler;

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $session = new SessionHandler();
    $session->setSession("productId", $productId);
    // $_POST['productId'] = $productId;
    
    $productObject = new Product();
    $currentProduct = $productObject->getProductById($productId);
} else {
    echo "Error updating product";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>

<body>
    <form action="../Controllers/updateProduct.php" method="POST">
        <div class="input">
            <label for="name">
                Product name:
            </label>
            <input type="text" name="productName" value=<?= $currentProduct['name'] ?> required>
        </div>
        <div class="input">
            <label for="price">
                Price:
            </label>
            <input type="text" name="productPrice" value=<?= $currentProduct['price'] ?> required>
        </div>
        <div class="input">
            <label for="quantity">
                Quantity:
            </label>
            <input type="text" name="productQuantity" value=<?= $currentProduct['quantity'] ?> required>
        </div>
        <div class="input">
            <input type="submit" name="submit" value="Submit">
        </div>
    </form>
</body>

</html>