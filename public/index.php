<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    session_destroy();
    header('Location: ../public/login.php');
    exit();
}

require_once '../config/db.php';
require_once '../classes/User.php';
require_once '../classes/Product.php';

use Product\Config\Database;
use Product\Classes\User;
use Product\Classes\Product;

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$product = new Product($db);

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $user_id = $_SESSION['user_id'] ?? null;
    $product_name = $_POST['product_name'] ?? null;
    $price = $_POST['price'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    switch ($action) {
        case 'add':
            $result = $product->addProduct($user_id, $product_name, $price, $quantity);
            $message = $result === true ? "Product added successfully!" : $result;
            break;
        case 'remove':
            $result = $product->removeProduct($user_id, $product_name, $price, $quantity);
            $message = $result === true ? "Product removed successfully!" : $result;
            break;
        default:
            $message = "Invalid action.";
            break;
    }
}

if (!empty($message)) {
    echo "<p>$message</p>";
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    include '../views/product.store.html';
} else {
    include '../views/index.html';
}
