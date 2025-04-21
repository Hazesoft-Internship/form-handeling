<?php

namespace Hazesoft\Backend\Controllers\CartController;

use Exception;
use Hazesoft\Backend\Models\CartItems;
use Hazesoft\Backend\Models\Product;
use Hazesoft\Backend\Services\Session;

class CartController
{
    private $productObject;
    private $cartObject;
    private $session;
    private $cartsObject;

    public function __construct()
    {
        $this->productObject = new Product();
        $this->cartObject = new CartItems();
        $this->session = Session::getInstance();
    }

    public function getCartDetailsPage()
    {
        $viewData = $this->handleCartDetailsData();
        extract($viewData);
        return require_once(__DIR__ . '/../../Views/cart-details-page.php');
    }

    public function getInsertCartProductPage()
    {
        $viewData = $this->handleInsertCartProductData();
        extract($viewData);
        return require_once(__DIR__ . '/../../Views/insert-cart-product.php');
    }

    public function handleInsertCartProductPage()
    {
        try {
            if (isset($_POST['productId'])) {
                $productId = $_POST['productId'];
                $userId = $this->session->getSession("userId");
                $quantity = $_POST['quantity'];

                $totalQuantity = $this->productObject->getProductQuantity($productId);

                // Check whether the requested quantity of product is available or not
                if ($quantity > $totalQuantity) {
                    echo ("The total quantity of this product is only: " . $totalQuantity . "<br>Please request less orders");
                    exit;
                }

                $existingItem = $this->cartObject->getItemById($productId, $userId);

                if ($existingItem) {
                    // Update quantity
                    $isInsertionDone = $this->cartObject->updateCartItem($productId, $userId, $quantity);
                } else {
                    // Insert new item
                    $isInsertionDone = $this->cartObject->insertCartItems($productId, $quantity, $userId);
                }

                if ($isInsertionDone) {
                    header("Location: /products");
                } else {
                    echo ("Error adding to cart");
                }
            } else {
                echo "Product Id not found";
            }
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
        }
    }

    public function handleDeleteCartItem()
    {
        try {
            if (isset($_POST['product_id'])) {
                $productId = $_POST['product_id'];
                $userId = $this->session->getSession("userId");

                $this->cartObject->deleteCartItem($productId, $userId);
                header("Location: /cart/details");
            } else {
                echo "Error deleting cart from CartController";
            }
        } catch (Exception $exception) {
            echo ("Error " . $exception->getMessage());
        }
    }

    public function handleInsertCartProductData()
    {
        if (isset($_GET['id'])) {
            $productId = $_GET['id'];
            $userId = $this->session->getSession("userId");

            $product = $this->productObject->getProductById($productId);
            $cart = $this->cartObject->getItemById($productId, $userId);

            return [
                'productId' => $productId,
                'product' => $product,
                'cart' => $cart
            ];
        } else {
            echo "Error adding to cart";
        }
    }

    public function handleCartDetailsData()
    {
        try {
            $userId = $this->session->getSession("userId");

            $cartItems = $this->cartObject->getCartItems($userId);

            $totalPrice = array_reduce($cartItems, [$this, 'addPrice'], 0);

            return [
                'cartItems' => $cartItems,
                'totalPrice' => $totalPrice
            ];
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
        }
    }

    public function addPrice($carry, $item2)
    {
        return $carry + $item2["item_total_price"];
    }
}
