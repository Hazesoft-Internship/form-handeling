<?php

namespace App\controller;

use App\model\Product;
use App\config\Database;
use App\session\Session;
use App\Exception\CustomException;

class ProductController
{

    private $productModel;

    public function __construct()
    {
        $conn = Database::getInstance();
        $db = $conn->getConnection();
        $this->productModel = new Product($db);
    }

    public function getAllProducts()
    {
        $storeProduct = $this->productModel->getAllProducts();
        $session = new Session();

        $hasSession = $session->hasSession("user_id");


        if ($hasSession) {
            $storeProduct = [];
            $storeProduct = $this->productModel->getProducts();
        } else {
            $storeProduct = [];
            $storeProduct = $this->productModel->getAllProducts();
        }
        include(__DIR__ . "/../view/product.php");
    }

    public function getUserProducts()
    {
        $session = new Session();

        $id = $session->getSession("user_id");
        $storeProduct = $this->productModel->getMyProducts($id);
        include(__DIR__ . "/../view/myProduct.php");
    }

    public function addProduct()
    {
        $session = new Session();
        $userId = $session->getSession("user_id");
        $name = $_POST["name"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        if (empty($name) || empty($price) || empty($quantity)) {
            echo "something went wrong while adding product";
            return;
        } else {
            $this->productModel->addProduct($name, $price, $quantity, $userId);
        }
    }

    public function deleteProduct()
    {
        $productId = (int)$_POST["id"];
        $this->productModel->deleteProduct($productId);
    }

    public function getSingleProduct()
    {
        $productId = $_GET['id'] ?? null;

        if (!$productId) {
            return;
        } else {
            $singleProduct = $this->productModel->getSingleProduct($productId);
            include(__DIR__ . "/../view/UpdateProduct.php");
        }
    }

    public function updateProduct()
    {
        $productId = (int)$_POST["id"];
        $productName = $_POST["name"];
        $productPrice = $_POST["price"];
        $productQuantity = $_POST["quantity"];

        try {
            $this->productModel->updateProduct($productId, $productName, $productQuantity, $productPrice);
        } catch (CustomException $exception) {
            echo $exception->getMessage() . $exception->getCode();
            foreach ($exception->getTheError() as $errorTitle => $errorMessage) {
                echo $errorMessage;
            }
        }
    }
}
