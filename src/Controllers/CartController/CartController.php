<?php

namespace ECommerce\Controllers\CartController;

use ECommerce\Models\CartItems;
use ECommerce\Services\Session;

class CartController
{
    private $cart;
    private $session;
    public function __construct()
    {
        $this->cart = new CartItems();
        $this->session = Session::getInstance();
    }

    public function handleAddItemtoCart()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $userID = $this->session->get("userID");
            $productID = $_GET['productID'];
            $quantity = $_POST['quantity'];

            if ($this->cart->checkProductStock($productID, $quantity)) {
                $result = $this->cart->addItemToCart($userID, $productID, $quantity);
            } else {
                echo "Provide is out of stock";
                return;
            }

            if ($result) {
                header('Location: /mycart');
            } else {
                echo "Failed to add to cart";
            }
        }
    }

    public function handleDeleteCartItem()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cartItemID = $_GET["cartItemID"];
            $deletionResult = $this->cart->deleteCartItem($cartItemID);
            if ($deletionResult) {
                header("Location: /mycart");
            } else {
                echo "Deletion of cart item unsuccessful";
            }
        }
    }

    public function getMyCartPage()
    {
        $userID = $this->session->get("userID");
        $cartItems = $this->cart->getCartItems($userID);
        require_once __DIR__ . '/../../Views/my-cart.html';
    }
}
