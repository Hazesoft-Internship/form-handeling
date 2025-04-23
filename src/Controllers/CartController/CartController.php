<?php

namespace ECommerce\Controllers\CartController;

use ECommerce\Controllers\ModelParentClass;

class CartController extends ModelParentClass
{

    public function handleAddItemtoCart(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $userID = $this->session->get("userID");
            $productID = $_GET['productID'];
            $quantity = $_POST['quantity'];
            $remainingQuantity = $this->cartItems->getProductStock($productID);

            if ($remainingQuantity['quantity'] >= $quantity) {
                $cart = $this->cart->getCartByUserID($userID);

                if (!$cart) {
                    $this->cart->createUserCart($userID);
                    $cart = $this->cart->getCartByUserID($userID);
                }
                $cartID = $cart['id'];
                $existingItem = $this->cartItems->getCartItem($cartID, $productID);

                if ($existingItem) {
                    $id = $existingItem['id'];
                    $result = $this->cartItems->updateCartProductQuantity($quantity, $id);
                } else {
                    $result = $this->cartItems->addItemToCart($cartID, $productID, $quantity);
                }
            } else {
                echo "Product is out of stock";
                return;
            }

            if (isset($result) && $result) {
                header('Location: /mycart');
            } else {
                echo "Failed to add to cart";
            }
        }
    }

    public function handleDeleteCartItem(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cartItemID = $_GET["cartItemID"];
            $deletionResult = $this->cartItems->deleteCartItem($cartItemID);
            if ($deletionResult) {
                header("Location: /mycart");
            } else {
                echo "Deletion of cart item unsuccessful";
            }
        }
    }

    public function getMyCartPage(): void
    {
        $userID = $this->session->get("userID");
        $cartItems = $this->cartItems->getCartItemsDetail($userID);
        require_once __DIR__ . '/../../Views/my-cart.html';
    }
}
