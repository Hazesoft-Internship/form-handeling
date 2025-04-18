<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Model\Product;
use Lattefront\FormHandeling\Service\FormValidation;
use Lattefront\FormHandeling\Session\Session;


class ProductController
{
    private Session $session;
    public function __construct()
    {
        $this->session = Session::getInstance(); // Initialize the session instance
    }
    public function addproductpage(): void
    {
        require __DIR__ . '/../View/productadd.php';
    }
    public function addproduct(): void
    {
        // Sanitize and validate inputs
        $product_name = strip_tags($_POST['product_name']);
        $product_quantity = filter_var($_POST['product_quantity'],FILTER_SANITIZE_NUMBER_INT);
        $product_price = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_INT);
        $product_description = strip_tags($_POST['product_description']);

        if ($errors = FormValidation::validateProduct([$product_name, $product_quantity, $product_price, $product_description])) {
            // Handle errors 
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
        $addproduct = new Product(new DbConnection());
        $addproduct->insertProduct($product_name, $product_price, $product_description, $product_quantity);
    }
    public function myproductlist(): void
    {
        $viewproduct = new Product(new DbConnection());
        $row = $viewproduct->getmyProducts($this->session->getLoggedInUser());
        require __DIR__ . '/../View/Viewproduct.php';
    }

    public function getallproduct(): void
    {
        $loggedinemail = $this->session->getLoggedInUser();

        $viewproduct = new Product(new DbConnection());
        $row = $viewproduct->viewallProducts($loggedinemail?$loggedinemail:null);
        require __DIR__ . '/../View/viewallproduct.php';
    }
    public function updateproductpage(): void

    {
        $product_id = $_GET['id'];
        $product_name = $_GET['name'];
        $product_description = $_GET['description'];
        $product_quantity = $_GET['quantity'];
        $product_price = $_GET['price'];

        require __DIR__ . '/../View/updateproduct.php';
    }
    public function updateproduct(): void
    {
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $name = strip_tags($_POST['product_name']);
        $quantity = filter_var($_POST['product_quantity'], FILTER_SANITIZE_NUMBER_INT);
        $price = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_INT);
        $description = strip_tags($_POST['product_description']);

        if ($errors[] = FormValidation::validateProduct([$name, $quantity, $price, $description])) {
            
            // Handle errors 
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
            $updateproduct = new Product(new DbConnection());
            $updateproduct->updateProduct($id, $name, $quantity, $price, $description);
        
    }


    public function deleteproduct(): void
    {
        $id = filter_var($_POST['id']);
        $deleteuser = new Product(new DbConnection());
        $deleteuser->deleteproduct($id);
    }
}
