<?php

namespace App\controller;

use App\traits\DatetimeFormatter;

use App\session\Session;
use App\Exception\CustomException;
use App\controller\Constructor;
use App\controller\CartController;

class ProductController extends Constructor
{
    use DatetimeFormatter;

    public function displayProducts()
    {
        include(__DIR__ . "/../view/product.php");
    }

    public function displayAddProduct()
    {
        include(__DIR__ . "/../view/AddProduct.php");
    }


    public function getAllProducts()
    {
        $storeProduct = $this->productModel->getAllProducts();
        $session = Session::getInstance();
        $getSession = $session->getSession("user_id");
        $hasSession = $session->hasSession("user_id");
        $storeProduct = [];
        if ($hasSession) {
            $cart = new CartController();
            $formattedProduct = [];
            $storeProduct = $this->productModel->getProducts();
            foreach ($storeProduct as $singleProduct) {
                $singleProduct["inCart"] = $cart->productExistInCart($singleProduct["id"]);
                $singleProduct["created_at"] = $this->convertDateTime($singleProduct["created_at"]);
                $singleProduct["updated_at"] = $this->convertDateTime($singleProduct["updated_at"]);
                $formattedProduct[] = $singleProduct;
            }
        } else {
            $storeProduct = $this->productModel->getAllProducts();
            foreach ($storeProduct as $singleProduct) {
                $singleProduct["created_at"] = $this->convertDateTime($singleProduct["created_at"]);
                $singleProduct["updated_at"] = $this->convertDateTime($singleProduct["updated_at"]);
                $formattedProduct[] = $singleProduct;
            }
        }
        include(__DIR__ . "/../view/product.php");

    }

    public function getAllProductsJson()
    {
        $storeProduct = $this->productModel->getAllProducts();
        $session = Session::getInstance();

        $hasSession = $session->hasSession("user_id");


        $storeProduct = [];
        header("Content-Type: application/json");

        if ($hasSession) {
            $formattedProduct = [];
            $storeProduct = $this->productModel->getProducts();
            foreach ($storeProduct as $singleProduct) {

                $singleProduct["created_at"] = $this->convertDateTime($singleProduct["created_at"]);
                $singleProduct["updated_at"] = $this->convertDateTime($singleProduct["updated_at"]);
                $formattedProduct[] = $singleProduct;
            }

            $formattedProduct = json_encode($formattedProduct, JSON_PRETTY_PRINT);
        } else {
            $storeProduct = $this->productModel->getAllProducts();
            foreach ($storeProduct as $singleProduct) {

                $singleProduct["created_at"] = $this->convertDateTime($singleProduct["created_at"]);
                $singleProduct["updated_at"] = $this->convertDateTime($singleProduct["updated_at"]);
                $formattedProduct[] = $singleProduct;
            }
            $formattedProduct = json_encode($formattedProduct, JSON_PRETTY_PRINT);
        }

        include(__DIR__ . "/../view/allJsonProduct.php");
    }

    public function getUserProducts()
    {

        $id = $this->getSession("user_id");
        $storeProduct = $this->productModel->getMyProducts($id);
        foreach ($storeProduct as $singleProduct) {

            $singleProduct["created_at"] = $this->convertDateTime($singleProduct["created_at"]);
            $singleProduct["updated_at"] = $this->convertDateTime($singleProduct["updated_at"]);
            $formattedProduct[] = $singleProduct;
        }
        include(__DIR__ . "/../view/myProduct.php");
    }



    public function addProduct()
    {
        $userId = $this->getSession("user_id");
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

    public function addToCart() {}
}
