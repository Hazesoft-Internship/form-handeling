<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Model\Product;
use Lattefront\FormHandeling\Service\FormValidation;
use Lattefront\FormHandeling\Session\Session;


class ProductController extends Controller
{
    private Product $product;
    public function __construct()
    {
        parent::__construct();
        $this->product=new Product();

    }
    public function addproductpage(): void
    {
        require __DIR__ . '/../View/productadd.php';
    }
    public function addproduct(): void
    {
        // Sanitize and validate inputs
        $product_name = strip_tags($_POST['product_name']);
        $product_quantity = filter_var($_POST['product_quantity'], FILTER_SANITIZE_NUMBER_INT);
        $product_price = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_INT);
        $product_description = strip_tags($_POST['product_description']);
        $productTypes = strip_tags($_POST['productTypes']);

        if ($errors = FormValidation::validateProduct([$product_name, $product_quantity, $product_price, $product_description])) {
            // Handle errors 
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
        $this->product->insertProduct($product_name, $product_price, $product_description, $product_quantity, $productTypes);
    }
    public function myproductlist(): void
    {
        $row = $this->product->getmyProducts($this->session->getLoggedInUser());
        // print_r($row);
        require __DIR__ . '/../View/Viewproduct.php';
    }

    public function getallproduct(): void
    {
        $loggedinemail = $this->session->getLoggedInUser();
        $row = $this->product->viewallProducts($loggedinemail ? $loggedinemail : null);
        require __DIR__ . '/../View/viewallproduct.php';
    }
    public function updateproductpage(): void

    {
        $product_id = $_GET['id'];
        $product_name = $_GET['name'];
        $product_description = $_GET['description'];
        $product_quantity = $_GET['quantity'];
        $product_price = $_GET['price'];
        $productTypes = $_GET['productTypes'];

        require __DIR__ . '/../View/updateproduct.php';
    }
    public function updateproduct(): void
    {
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $name = strip_tags($_POST['product_name']);
        $quantity = filter_var($_POST['product_quantity'], FILTER_SANITIZE_NUMBER_INT);
        $price = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_INT);
        $description = strip_tags($_POST['product_description']);
        $productTypes = strip_tags($_POST['productTypes']);

        if ($errors[] = FormValidation::validateProduct([$name, $quantity, $price, $description])) {

            // Handle errors 
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
        $this->product->updateProduct($id, $name, $quantity, $price, $description, $productTypes);
    }


    public function deleteproduct(): void
    {
        $id = filter_var($_POST['id']);
        $this->product->deleteproduct($id);
    }
}
