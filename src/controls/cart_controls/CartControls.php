<?php

namespace ayushtamang\FormHandeling\controls\cart_controls;

use ayushtamang\FormHandeling\model\CartItems;
use ayushtamang\FormHandeling\controls\Sanitizer;
use ayushtamang\FormHandeling\database\Database;
use ayushtamang\FormHandeling\model\GetProductDetails;

class CartControls
{
    private $con;
    private $cartItems;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->con = $db->getConnection();
        $this->cartItems = new CartItems($this->con);
    }

    public function getCart()
    {
        require __DIR__ . "/../../view/cart.php";
    }

    public function getUpdateCart()
    {
        require __DIR__ . "/../../view/updateCart.php";
    }

    public function addCartSubmit()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productId = $_GET["id"];
            $quantity = Sanitizer::sanitizeInteger($_POST["quantity"]);
            $product = new GetProductDetails($this->con, $productId);
            $price = $product->getProductPrice();
            $price = $quantity * $price;

            try {
                if ($this->cartItems->addCartItem($productId, $quantity, $price)) {
                    header("Location: /product");
                }
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();   
            }
        }
    }

    public function updateCartSubmit()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productId = $_GET["id"];
            $quantity = Sanitizer::sanitizeInteger($_POST["quantity"]);
            $product = new GetProductDetails($this->con, $productId);
            $price = $product->getProductPrice();
            $price = $quantity * $price;

            try {
                if ($this->cartItems->updateCartItem($productId, $quantity, $price)) {
                    header("Location: /product/cart");
                }
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function deleteCartSubmit()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productId = $_GET["id"];
            try {
                if ($this->cartItems->deleteCartItem($productId)) {
                    header("Location: /product/cart");
                }
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
?>