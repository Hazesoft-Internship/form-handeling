<?php

namespace App\controller;

use App\controller\Constructor;
use App\session\Session;

class CartController extends Constructor
{

  public function displayCheckoutPage()
  {
    include(__DIR__ . "/../view/checkout.php");
  }

  public function getOrCreateCart()
  {
    $userId = $this->getSession("user_id");
    $activeCart = $this->cartModel->getCart($userId);

    if ($activeCart) {
      return $activeCart["id"];
    } else {
      return $this->cartModel->createCart($userId);
    }
  }

  public function addToCart()
  {
    $cartId = $this->getOrCreateCart();
    $productId = $_POST["productId"];
    $price = $_POST["price"];
    if ($cartId) {
      $this->cartItemModel->addToCart($cartId, $productId, $price);
      header("Location:/cart");
    }
  }

  public function getUserCartItem()
  {
    $userId = $this->getSession("user_id");
    $userCartItems = $this->cartItemModel->getCartItem($userId);
    include(__DIR__ . "/../view/cart.php");
    return $userCartItems;
  }

  public function productExistInCart($productId)
  {
    $userId = $this->getSession("user_id");
    $cartItems = $this->cartItemModel->getCartItem($userId);
    $cartExist = false;
    foreach ($cartItems as $cartItem) {
      if ($cartItem["product_id"] === $productId) {
        $cartExist = true;
        break;
      }
    }
    return $cartExist;
  }


  public function updateCartQuantity()
  {
    $items = $_POST["items"];
    $this->cartItemModel->updateCartQuantity($items);
  }
}
