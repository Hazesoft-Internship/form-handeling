<?php
require 'src/Config/DB.php';
require 'src/Exceptions/ValidationExceptions.php';
require 'src/Exceptions/DatabaseExceptions.php';
require 'src/Models/Product.php';

use src\Config\DB;
use src\Models\Product;
use src\Exceptions\ValidationException;
use src\Exceptions\DatabaseException;

try {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.html');
        exit;
    }

    $product = new Product();
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_name = htmlspecialchars($_POST['product_name']);
        $price = (float)$_POST['price'];
        $quantity = (int)$_POST['quantity'];

        $product->addProduct($user_id, $product_name, $price, $quantity);
        echo "Product added successfully!";
    }
} catch (ValidationException $e) {
    $e->handle();
} catch (DatabaseException $e) {
    $e->handle();
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <form method="POST">
        <label>Name: <input type="text" name="product_name" required></label><br>
        <label>Price: <input type="number" name="price" step="0.01" required></label><br>
        <label>Quantity: <input type="number" name="quantity" required></label><br>
        <input type="submit" value="Add Product">
    </form>
    <button onclick="location.href='login.html'">Logout</button>
</body>
</html>