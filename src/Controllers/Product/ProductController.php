<?php

namespace App\Controllers\Product;

use App\Controllers\Controller;
use App\Models\Product\ProductModel;
use App\Validation\ProductValidation;


class ProductController extends Controller
{

    public ProductValidation $validation;
    public ProductModel $product;

    public function __construct()
    {

        parent::__construct();
        $this->validation = new ProductValidation();
        $this->product = new ProductModel;
    }

    public function addProductPage()
    {
        require_once __DIR__ . '/../../Views/addProduct.php';
    }

    public function myProductsPage()
    {
        $products = (new ProductController())->userProducts();

        require_once __DIR__ . '/../../Views/myproducts.php';
    }
    public function productJsonPage()
    {
        require_once __DIR__ . '/../../Views/productJson.php';
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
        $type = $_POST['type'] ?? '';

        $userId = $this->session->getSession('user')['user_id'];



        $this->validation->insertProduct($name, $description, $price, $quantity, $userId);

        $this->product->insertProduct($name, $description, $price, $quantity, $userId, $type);
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

        // $product = new ProductModel();
        if ($this->product->updateProduct($id, $name, $description, $price, $quantity)) {
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

        // $product = new ProductModel();
        if ($this->product->deleteProduct($id)) {
            echo "Product deleted successfully!";
        }
    }

    public function listProducts(): array|null
    {

        // $product = new ProductModel();
        $products = $this->product->getAllProducts();
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
        // $product = new ProductModel();
        $products = $this->product->getUserProducts($userId);
        if (empty($products)) {
            echo "No products found.";
            return null;
        }
        return $products;
    }
}
