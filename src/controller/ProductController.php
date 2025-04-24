<?php

namespace App\controller;
require_once __DIR__."/../../vendor/autoload.php";

use App\Model\Database;
use App\validation\ProductValidation;
use App\session\session;
use App\Model\Product;

class ProductController
{
    private $product1;
    public function __construct()
    {
        $this->product1 = new Product();
    }

    //this handles the get request for the add product page
    public function getAddProduct(): pathinfo
    {
        $userName = strtoupper(session::getInstance()->get("userName"));
        return require_once __DIR__."/../View/products/addProduct.php";
    }
    
    // this handles the post request from the add product page
    public function handleAddProduct(): void
    {
        $productName = htmlspecialchars(trim($_POST["productName"]));
        $quantity = htmlspecialchars(trim($_POST["quantity"]));
        $price = htmlspecialchars(trim($_POST["price"]));
        $userID = session::getInstance()->get("userID");
        $this->product1->addProduct($productName, $quantity, $price, $userID);
    }

    // this handles the get request for the view all products
    public function handleViewAllProduct(): int
    {
        $userID = session::getInstance()->get("userID");
        $data = $this->product1->viewAllProduct($userID);
        return require_once __DIR__."/../View/products/viewAllProduct.php";
    }

    //this handles the post request for the view your product page
    public function handleViewYourProduct(): int
    {
        
        $userID = session::getInstance()->get("userID");
        $data = $this->product1->viewYourProduct($userID);
        return require_once __DIR__."/../View/products/viewYourProduct.php";
    }

    //this handles the get request for the deletion fo the product
    public function deleteProduct(): void
    {
        $id = $_GET["id"];
        $this->product1->deleteProduct($id);
    }

    //this handles the post request for the update product
    public function updateProduct(): void
    {
        $updatedPrice = $_POST['updatedPrice'];
        $updatedQuantity = $_POST['updatedQuantity'];
        $id = $_POST['id'];
        $this->product1->updateProduct($updatedPrice, $updatedQuantity, $id);
    }

    //this handles the post request to read the update from the user
    public function showReadUpdate(): int
    {
        $id = $_GET['id'];
        $product =  $this->product1->readUpdate($id);
        $userName = strtoupper(session::getInstance()->get("userName"));
        return require_once __DIR__."/../View/products/readUpdate.php";
    }
}
