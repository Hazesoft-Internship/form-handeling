<?php
require("../../../vendor/autoload.php");

use App\controller\ProductController;
use App\config\Database;
use App\session\Session;
use App\validate\ProductValidation;


$db = Database::getInstance();
$conn = $db->getConnection();
$validate = new ProductValidation();


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "something went wrong while adding product";
    return;
} else {
    $session = new Session();
    $userId = $session->getSession("user_id");
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $product = new ProductController($conn,$validate);
    $product->addProduct($name, $price, $quantity, $userId);
}
