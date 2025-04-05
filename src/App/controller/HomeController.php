<?php

namespace App\controller;

class HomeController
{
    public function index()
    {
        include(__DIR__ . "/../view/register.php");
    }

    public function login()
    {
        include(__DIR__ . "/../view/login.php");
    }
    
    public function main()
    {
        include(__DIR__ . "/../view/product.php");
    }

    public function addProduct()
    {
        include(__DIR__ . "/../view/AddProduct.php");
    }
}
