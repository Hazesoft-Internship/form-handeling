<?php

namespace App\Controllers\Cart;

use App\Controllers\Controller;
use App\Models\Cart\CartModel;
use App\Sessions\Sessions;
use Exception;

class CartController extends Controller
{
    public $cart;


    public function __construct()
    {
        parent::__construct();
        $this->cart = new CartModel();
    }

    public function cartPage()
    {

        $cartItems = $this->viewCart();
        if ($cartItems === null) {
            echo "No items in cart";
            exit();
        }

        $total = 0;
        foreach ($cartItems as $item) {

            $subtotal = $item['price'] * $item['cart_quantity'];
            $total += $subtotal;
        }
        require_once __DIR__ . '/../../Views/cartPage.php';
    }

    public function cartExist()
    {
        try {
            $user_id = $this->session->getSession('user')['user_id'];
            if (!$this->cart->getCartIdByUserId($user_id)) {
                return false;
            }
            return true;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function createCart()
    {
        try {
            $user_id = $this->session->getSession('user')['user_id'];
            if (!$this->cartExist()) {
                $isCreated = $this->cart->createCart($user_id);
                if ($isCreated) {
                    echo "Cart created successfully";
                    return true;
                }
                return false;
            }
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function getCartId()
    {
        try {
            $user_id = $this->session->getSession('user')['user_id'];


            $cartId = $this->cart->getCartIdByUserId($user_id);
            if (!$cartId) {
                return false;
            }
            return $cartId;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
    public function addToCart()
    {
        try {

            if (!$this->cartExist()) {
                $this->createCart();
            }

            $cart_id = $this->getCartId();
            if ($cart_id == false) {
                throw new Exception("Cart id not found!");
            }

            if (!isset($_POST['product_id'])) {

                throw new Exception("Product id not found!");
            }

            $productId = $_POST['product_id'];

            if ($this->cart->isProductInCart($productId)) {
                header('Location: /cart');
                exit();
            }

            $isInserted = $this->cart->insertToCart($cart_id, $productId);
            if ($isInserted) {
                header('Location: /cart');
                exit();
            }
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function viewCart(): array|null
    {
        try {
            $cartId = $this->getCartId();
            $cartItems = $this->cart->getUserCartItems($cartId);
            if ($cartItems) {
                return $cartItems;
            }
            return null;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return null;
        }
    }

    public function removeFromCart()
    {
        try {
            if (!isset($_POST['cart_item_id'])) {
                echo 'cart_item_id not found';
                exit();
            }

            $cart_item_id = $_POST['cart_item_id'];
            $is_deleted = $this->cart->removeItem($cart_item_id);
            if ($is_deleted) {
                echo "Deleted Succesfully";
            }
        } catch (Exception $exception) {
            echo "Error:" . $exception->getMessage();
        }
    }

    public function updateCartQuantity()
    {
        try {
            if (!isset($_POST['cart_item_id']) || !isset($_POST['next_cart_quantity'])) {
                echo 'cart_item_id and quantity not found';
                exit();
            }
            $updatedQuantity = $_POST['next_cart_quantity'];
            $cart_item_id = $_POST['cart_item_id'];
            $product_quantitiy = $_POST['product_quantity'];

            if ($updatedQuantity > $product_quantitiy) {
                echo "Cannot add more quantity then the stock!";
                exit();
            }
            $isUpdated = $this->cart->updateCart($cart_item_id, $updatedQuantity);
            if ($isUpdated) {
                echo "Cart quantity updated successfully";
                exit();
            }
            echo "Unable to update";
        } catch (Exception $exception) {
            echo "Error:" . $exception->getMessage();
        }
    }
}
