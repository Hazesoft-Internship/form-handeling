<?php
require("../../../vendor/autoload.php");

use App\model\Product;
use App\config\Database;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = (int)$_POST["id"];
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $product = new Product($conn);
    $product->deleteProduct($productId);
} else {
    echo "something went wrong";
}
