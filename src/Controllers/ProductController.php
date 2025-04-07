<?php

namespace App\Controllers;

use App\Config\DataBase;
use App\Models\ProductModel;
use App\Sessions\Sessions;


class ProductController
{

    public object $connection;

    public function __construct()
    {
        $this->connection = DataBase::connect();
    }

    public function addProduct(): void
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request method");
        }
        if (!isset($_POST['name'], $_POST['description'], $_POST['price'], $_POST['quantity'])) {
            die("Missing required fields");
        }
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        session_start();
        $userId = $_SESSION['user']['user_id'];



        $product = new ProductModel();
        $product->insertProduct($name, $description, $price, $quantity, $userId);
    }

    public function updateProduct()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request method");
        }
        if (!isset($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['quantity'])) {
            die("Missing required fields");
        }
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $quantity = $_POST['quantity'] ?? '';


        $product = new ProductModel();
        if ($product->updateProduct($id, $name, $description, $price, $quantity)) {
            echo "Product updated successfully!";
        }
    }

    public function deleteProduct(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request method");
        }
        if (!isset($_POST['id'])) {
            die("Missing required fields");
        }
        $id = $_POST['id'] ?? '';

        $product = new ProductModel();
        if ($product->deleteProduct($id)) {
            echo "Product deleted successfully!";
        }
    }

    public function listProducts(): array|null
    {

        $product = new ProductModel();
        $products = $product->getAllProducts();
        if (empty($products)) {
            echo "No products found.";
            return null;
        }
        return $products;
    }

    public function userProducts(): array|null
    {
        $session = new Sessions();
        // $userId = $session->getSession('user')['id'];
        session_start();
        $userId = $_SESSION['user']['user_id'];
        if ($userId === null) {
            echo "User not logged in.";
            return null;
        }
        $product = new ProductModel();
        $products = $product->getUserProducts($userId);
        if (empty($products)) {
            echo "No products found.";
            return null;
        }
        return $products;
    }
}
