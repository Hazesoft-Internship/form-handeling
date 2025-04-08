<?php

namespace App\Controllers;

class RouteController
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
        require_once __DIR__ . '/../Views/listproducts.php';
    }


    public function homePage()
    {
        require_once __DIR__ . '/../Views/home.php';
    }
    public function myProductsPage()
    {
        require_once __DIR__ . '/../Views/myproducts.php';
    }
}
