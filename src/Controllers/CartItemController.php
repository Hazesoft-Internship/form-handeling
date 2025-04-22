<?php

namespace Hazesoft\Formhandeling\Controllers;


class CartItemController extends BaseController
{
    public function addToCart(): void
    {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $product = $this->productModel->getProductById($productId);

        if ($product && $product['quantity'] >= $quantity) {
            $cartId = $this->cartModel->getOrCreateCart($this->userid);

            $cartItem = $this->cartItemModel->getCartItem($cartId, $productId);

            $cartItemId = $cartItem['id'];

            if ($cartItem) {
                $this->cartItemModel->updateCartItemQuantity($cartItemId, $quantity);
            } else {
                $this->cartItemModel->addCartItem($cartId, $productId, $quantity);
            }

            header("Location: /cart/$cartId");
            exit;
        } else {
            echo "Not enough stock or product not found.";
        }
    }

    public function updateAllCartItems(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $cartId = $this->cartModel->getOrCreateCart($this->userid);
            $quantities = $_POST['quantity'];

            foreach ($quantities as $cartItemId => $newQty) {

                $cartItem = $this->cartItemModel->getCartItemById($cartItemId);
                $product = $this->productModel->getProductById($cartItem['product_id']);

                if ($product && $newQty <= $product['quantity']) {
                    $this->cartItemModel->updateCartItemQuantity($cartItemId, $newQty);
                } else {
                    echo "Not enough product";
                }
            }
            header("Location: /cart/$cartId");
            exit;
        }
    }

    public function deleteCartItem(): void
    {
        $cartId = $this->cartModel->getOrCreateCart($this->userid);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $_POST['cart_item_id'] ?? null;

            if ($cartItemId) {
                $this->cartItemModel->deleteCart($cartItemId);
            }
        }
        header("Location: /cart/$cartId");
        exit();
    }
}
