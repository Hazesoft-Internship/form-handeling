<?php

namespace App\Controllers;


use App\Models\ProductModel;
use App\Sessions\Sessions;
use App\Validation\ProductValidation;

class ProductController
{


    public Sessions $session;
    public ProductValidation $validation;

    public function __construct()
    {

        $this->session = Sessions::getInstance();
        $this->validation = new ProductValidation();
    }

    public function addProductPage()
    {
        require_once __DIR__ . '/../Views/addProduct.php';
    }
    
    public function myProductsPage()
    {
        $products = (new ProductController())->userProducts();

        require_once __DIR__ . '/../Views/myproducts.php';
    }
    public function productJsonPage()
    {
        require_once __DIR__ . '/../Views/productJson.php';
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

        $userId = $this->session->getSession('user')['user_id'];


        $this->validation->insertProduct($name, $description, $price, $quantity, $userId);

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

        $this->validation->updateProduct($name, $description, $price, $quantity);

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

        $userId = $this->session->getSession('user')['user_id'] ?? null;



        // $userId = $_SESSION['user']['user_id'];
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
