<?php

namespace App\controller;

require_once __DIR__."/../../vendor/autoload.php";

use App\connectDB\Database;
use App\connectDB\UploadProduct;
use App\validation\ProductValidation;
use App\session\session;

class ProductController
{
    private string $productName;
    private int $quantity;
    private float $price;

    //this handles the get request for the add product page
    public function getAddProduct()
    {
        $userName = strtoupper(session::getInstance()->get("userName"));
        return require_once __DIR__."/../dashboard/products/addProduct.php";
    }
    
    // this handles the post request from the add product page
    public function handleAddProduct()
    {
        $this->productName = htmlspecialchars(trim($_POST["productName"]));
        $this->quantity = htmlspecialchars(trim($_POST["quantity"]));
        $this->price = htmlspecialchars(trim($_POST["price"]));
    
        $prod1 = new UploadProduct();
        $prod1->createProduct($this->productName, $this->quantity, $this->price);
    }

    // this handles the get request for the view all products
    public function handleViewAllProduct()
    {
        $userID = session::getInstance()->get("userID");
        try
        {
            $conn = Database::getInstance()->getConnection();
        }
        catch(PDOException $e)
        {
            die("Connection failed: " . $e->getMessage());
        }
        
        $sql = "SELECT * FROM products where userID != '$userID'";
        $result = $conn->prepare($sql);
        $result->execute();
        $data = $result->fetchAll();
        return require_once __DIR__."/../dashboard/products/viewAllProduct.php";
    }

    //this handles the post request for the view your product page
    public function handleViewYourProduct()
    {
        try
        {
            $conn = Database::getInstance()->getConnection();
        }
        catch(PDOException $e)
        {
            die("Connection failed: " . $e->getMessage());
        }
        
        $userID = session::getInstance()->get("userID");
        $sql = "SELECT * FROM products where userID='$userID'";
        $result = $conn->prepare($sql);
        $result->execute();
        $data = $result->fetchAll();
        return require_once __DIR__."/../dashboard/products/viewYourProduct.php";
    }

    //this handles the get request for the deletion fo the product
    public function deleteProduct()
    {
        return require_once __DIR__."/deleteProduct.php";
    }

    //this handles the post request for the update product
    public function updateProduct()
    {
        return require_once __DIR__."/updateProduct.php";
    }

    //this handles the post request to read the update from the user
    public function showReadUpdate()
    {
        $id = $_GET['id'];
        try
        {
            $conn = Database::getInstance()->getConnection();
        }
        catch(PDOException $e)
        {
            die("Connection Error" . $e->getMessage());
        }
        
        $sql = "SELECT * FROM products WHERE id = $id";
        $result = $conn->query($sql);
        
        if($result)
        {
            $product = $result->fetch();
        }
        else
        {
            echo "Product not found on database";
        }
        
        $userName = strtoupper(session::getInstance()->get("userName"));
        return require_once __DIR__."/../dashboard/products/readUpdate.php";
    }
}
