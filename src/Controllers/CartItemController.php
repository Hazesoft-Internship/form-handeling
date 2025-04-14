<?php

namespace Hazesoft\Formhandeling\Controllers;

use Hazesoft\Formhandeling\Services\Session;
use Hazesoft\Formhandeling\Models\Product;
use Hazesoft\Formhandeling\Models\Cart;
use Hazesoft\Formhandeling\Models\CartItem;
use Hazesoft\Formhandeling\Services\View;
use Hazesoft\Formhandeling\Services\DateFormatter;

$session = Session::getInstance();

$session->start();


class CartItemController
{
    use DateFormatter;
    private $productModel;
    private $cartModel;
    private $cartItemModel;
    public $userid;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->cartItemModel = new CartItem();
        $this->productModel = new Product();
        $this->userid = $_SESSION['id'] ?? null;
    }

    public function addToCart()
    {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $product = $this->productModel->getProductById($productId);

        if ($product && $product['quantity'] > $quantity) {
            $cartId = $this->cartModel->getOrCreateCart($this->userid);

            $cartItem = $this->cartItemModel->getCartItem($cartId, $productId);

            $cartItemId = $cartItem['id'];

            if ($cartItem) {
                $this->cartItemModel->updateCartItemQuantity($cartItemId, $quantity);
            } else {
                $this->cartItemModel->addCartItem($cartId, $productId, $quantity);
            }

            header("Location: /cart/$cartId");
        } else {
            echo "Not enough stock or product not found.";
        }
    }

    public function cartItemDetail($id)
    {
        $cartItem = $this->cartItemModel->getCartItemsById($id);
        $cartItem['created_at'] = $this->convertDateTime($cartItem['created_at']);
        $cartItem['updated_at'] = $this->convertDateTime($cartItem['updated_at']);
        View::render('cart_item_detail', ['cartItem' => $cartItem]);
    }
}
