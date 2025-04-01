<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("../../../vendor/autoload.php");

use App\config\Database;
use App\model\Product;


use App\session\Session;

$session = new Session();
$db = database::getInstance();
$conn = $db->getConnection();

if ($session->hasSession("user_id")) {
    $storeProduct = [];
    $product = new Product($conn);
    $storeProduct = $product->getAllProducts();
} else {
    $storeProduct = [];
    $product = new Product($conn);
    $storeProduct = $product->getAllProducts();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
</head>

<body>
    <h1>Product List</h1>
    <?php if (!empty($storeProduct)): ?>
        <div>
            <?php foreach ($storeProduct as $product): ?>
                <div>
                    <strong>Name:</strong> <?php echo $product['name']; ?>
                    <strong>Quantity:</strong> <?php echo $product['quantity']; ?>
                    <strong>Price:</strong> $<?php echo $product['price']; ?>
                    <?php if ($session->getSession("user_id") === $product["user_id"]): ?>
                        <form action="../controller/ProductDelete.php" method="post">
                            <input name="id" type="hidden" value="<?php echo $product["id"] ?>" />
                            <button type="submit">delete</button>
                        </form>

                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No products available.</p>
    <?php endif; ?>

    <?php if ($session->hasSession("user_id")): ?>
        <a href="./AddProduct.html"> <button style=" padding:10px;">add product</button></a>
    <?php endif; ?>
    </form>

    <a href="/form-handeling/logout.php"><button>Logout</button></a>
</body>

</html>