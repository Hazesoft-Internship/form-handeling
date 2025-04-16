<?php

namespace ECommerce\Controllers\ProductController;

use ECommerce\Services\Session;
use ECommerce\Models\Product;
use ECommerce\Utils\Validation\ValidateProduct;

class ProductController
{
    private $product;
    private $session;
    private $validateProduct;

    public function __construct()
    {
        $this->product = new Product();
        $this->session = Session::getInstance();
        $this->validateProduct = new ValidateProduct();
    }

    public function handleAddProductForm()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product-submit'])) {
            $productName = $_POST["productName"];
            $productPrice = $_POST["productPrice"];
            $productQuantity = $_POST["productQuantity"];
            $userID = $this->session->get("userID");

            $sanitizedUserInput = $this->validateProduct->validateUserInput([$productName, $productPrice, $productQuantity]);

            if (isset($sanitizedUserInput["error"])) {
                echo $sanitizedUserInput["error"];
            }
            $addProductResult = $this->product->addProduct($sanitizedUserInput[0], $sanitizedUserInput[1], $sanitizedUserInput[2], $userID);
            if ($addProductResult) {
                echo "Product added successfully";
                header('Location: /myproducts');
                exit();
            }
            echo "Failed to add products";
        }
    }

    public function handleUpdateProductForm()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product-update'])) {
            $productID = $_GET['id'];
            $productName = $_POST['productName'] ?? null;
            $productPrice = $_POST['productPrice'] ?? null;
            $productQuantity = $_POST['productQuantity'] ?? null;

            $updateFields = [];
            $params = [];

            if ($productName !== null) {
                $updateFields[] = "name = :name";
                $params[':name'] = $productName;
            }
            if ($productPrice !== null && $productPrice !== '') {
                $updateFields[] = "price = :price";
                $params[':price'] = $productPrice;
            }
            if ($productQuantity !== null && $productQuantity !== '') {
                $updateFields[] = "quantity = :quantity";
                $params[':quantity'] = $productQuantity;
            }

            if (empty($updateFields)) {
                echo "Please update at least one field.";
                return;
            }

            $params[':productID'] = $productID;

            $updateResult = $this->product->updateProduct($updateFields, $params);

            if ($updateResult) {
                echo "Product updated successfully";
                header('Location: /myproducts');
                exit();
            }

            echo "Failed to update product";
        }
    }

    public function handleListAllProduct()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $userID = $this->session->get('userID');
            $allProducts = $this->product->listAllProduct($userID);

            if (!$allProducts) {
                return null;
            }
            return $allProducts;
        }
    }

    public function handleListMyProduct()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $userID = $this->session->get('userID');
            $myProducts = $this->product->listMyProduct($userID);

            if (!$myProducts) {
                return null;
            }
            return $myProducts;
        }
    }

    public function handleDeleteProduct()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $productID = $_GET['id'];
            $deleteProductResult = $this->product->deleteProduct($productID);
            if ($deleteProductResult) {
                echo "Product Deleted successfully";
                header('Location: /myproducts');
            }
            return "Failed to delete product";
        }
    }
    public function getProductByID($productID)
    {
        $productArray = $this->product->getUpdateProductByID($productID);
        if ($productArray) {
            return $productArray;
        }
        return null;
    }

    public  function getAddProductPage()
    {
        return require_once __DIR__ . '/../../Views/add-products.html';
    }
    public  function getUpdateProductPage()
    {
        $productByID = $this->getProductByID($_GET['id']);
        return require_once __DIR__ . '/../../Views/update-products.php';
    }
    public  function getAllProductPage()
    {
        $products = $this->handleListAllProduct();
        return require_once __DIR__ . '/../../Views/view-allproducts.html';
    }
    public  function getMyProductPage()
    {
        $products = $this->handleListMyProduct();
        return require_once __DIR__ . '/../../Views/view-myproducts.html';
    }

    public  function getAllProduct()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            header('Content-Type: application/json');
            $userID =  $this->session->get('userID');
            $allProducts = $this->product->listAllProduct($userID);

            if ($allProducts) {
                echo json_encode($allProducts);
            }
            return  JSON_ERROR_NONE;
        }
    }
}
