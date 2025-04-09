<?php


namespace App\Controllers;

use App\Controllers\ProductController;

class ViewController
{

    public function loginPage()
    {
        require_once __DIR__ . '/../Views/login.php';
    }
    public function registerPage()
    {
        require_once __DIR__ . '/../Views/signup.php';
    }
    public function addProductPage()
    {
        require_once __DIR__ . '/../Views/addProduct.php';
    }
    public function listProductsPage()
    {

        $products = (new ProductController())->listProducts();

        if (empty($products)) {
            echo "No products found.";
            return;
        }

        require_once __DIR__ . '/../Views/listproducts.php';
    }


    public function homePage()
    {
        require_once __DIR__ . '/../Views/home.php';
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
}
