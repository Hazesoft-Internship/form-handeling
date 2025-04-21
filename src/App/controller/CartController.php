<?php

namespace App\controller;

use App\controller\Constructor;
use App\session\Session;

class CartController extends Constructor
{
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

  public function addToCart($cartId,$productId)
  {
    $unitPrice = $this->productModel->getSingleProduct($productId);
    $price = $unitPrice["price"]; 
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

  public function productExistInCarts() {
    $cartId = $this->getOrCreateCart();
    $productId = (int)$_POST["productId"];
    if($this->cartItemModel->ProductExistInCart($cartId,$productId)) {
      $this->cartItemModel->incrementCartQuantity($cartId,$productId);
      header("Location:/cart");
      exit();
    } else {
      $this->addToCart($cartId,$productId);

    }
    
  }

  public function updateCartQuantity()
  {
    $items = $_POST["items"];
    $this->cartItemModel->updateCartQuantity($items);
  }
  public function deleteCartItem()
  {
    $cartItemId = (int)$_POST["cartItemId"];
    $this->cartItemModel->deleteCartItem($cartItemId);
    header("Location: /cart");
  }
}
