<?php

namespace ayushtamang\FormHandeling\controls\product_controls;

use ayushtamang\FormHandeling\model\Product;
use ayushtamang\FormHandeling\model\GetUserDetails;
use ayushtamang\FormHandeling\controls\Sanitizer;
use ayushtamang\FormHandeling\database\Database;
use ayushtamang\FormHandeling\session\Session;

class ProductControls
{
    private $product;
    private $con;
    private $session;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->con = $db->getConnection();
        $this->product = new Product($this->con);
        $this->session = Session::getInstance();
    }

    public function getProductStore()
    {
        require __DIR__ . "/../../view/productStore.php";
    }

    public function getAddProduct()
    {
        require __DIR__ . "/../../view/addproduct.php";
    }

    public function getProductProfile()
    {
        require __DIR__ . "/../../view/productProfile.php";
    }

    public function getProductUpdate()
    {
        require __DIR__ . "/../../view/updateProduct.php";
    }

    public function getProductBuy()
    {
        require __DIR__ . "/../../view/buyProduct.php";
    }

    public function addProductSubmit()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $ui = new GetUserDetails($this->con, $this->session->getSession("userLoggedIn"));
            $pn = Sanitizer::sanitizeString($_POST["productname"]);
            $pp = Sanitizer::sanitizeInteger($_POST["productprice"]);
            $pq = Sanitizer::sanitizeInteger($_POST["productquantity"]);
            
            try {
                if($this->product->addProduct($ui->getUserId(),  $pn, $pp, $pq)) {
                    header("Location: /product");
                } else {
                    echo "Failed to add product!";
                }
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function updateProductSubmit()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $userId = $this->session->getSession("userId");
            $productName = Sanitizer::sanitizeString($_POST["productname"]);
            $productPrice =Sanitizer::sanitizeInteger($_POST["productprice"]);
            $productQuantity = Sanitizer::sanitizeInteger($_POST["productquantity"]);
            $id = $this->session->getSession("productId");
        
            try {
                if($this->product->updateProduct($userId, $productName, $productPrice, $productQuantity, $id)) {
                    header("Location: /product/profile");
                } else {
                    echo "Failed to update product!";
                }
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function deleteProductSubmit()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $this->session->getSession("productId");
        
            if($this->product->deleteProduct($id)) {
                header("Location: /product/profile");
            } else {
                echo "Failed to delete product!";
            }
        }
    }
}
?>