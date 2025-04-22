<?php

namespace Hazesoft\Formhandeling\Controllers;

use Hazesoft\Formhandeling\Services\View;
use Hazesoft\Formhandeling\Services\ProductTypes\ProductFactory;

class CartController extends BaseController
{
    public function viewCart($id): void
    {
        $cartItems = $this->cartItemModel->getCartItems($id);
        $totalPrice = 0;
        foreach ($cartItems as &$cartItem) {
            $product = ProductFactory::create($cartItem['types'], $cartItem['price'], $cartItem['cartItemQuantity']);
            $cartItem['total'] = $product->calculateTotal();
            $totalPrice += $product->calculateTotal();
        }
        View::render('view_cart', ['cartItems' => $cartItems, 'totalPrice' => $totalPrice]);
    }
}
