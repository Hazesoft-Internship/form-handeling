<?php

namespace Hazesoft\Formhandeling\Controllers;

use Hazesoft\Formhandeling\Services\View;
use Hazesoft\Formhandeling\Services\CartPricingService;

class CheckoutController extends BaseController
{
    public function viewCheckout(): void
    {
        $cartId = $this->cartModel->getOrCreateCart($this->userid);
        $cartItems = $this->cartItemModel->getCartItems($cartId);
        $pricing = CartPricingService::calculate($cartItems);

        View::render('checkout', [
            'cartId' => $cartId,
            'cartItems' => $pricing['cartItems'],
            'totalPrice' => $pricing['total'],
            'tax' => $pricing['tax'],
            'grandTotal' => $pricing['grandTotal'],
            'paymentMethods' => $pricing['paymentMethods']
        ]);
    }
}
