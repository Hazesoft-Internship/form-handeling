<?php

namespace Hazesoft\Formhandeling\Controllers;

use Hazesoft\Formhandeling\Services\View;
use Hazesoft\Formhandeling\Services\CartPricingService;

class OrderController extends BaseController
{
    public function placeOrder(): void
    {
        $cartId = $this->cartModel->getOrCreateCart($this->userid);
        $cartItems = $this->cartItemModel->getCartItems($cartId);
        $pricing = CartPricingService::calculate($cartItems);
        $cartItems = $pricing['cartItems'];
        $address = $_POST['address'];
        $status = 'Pending';
        $paymentType = $_POST['payment_method'];
        $totalAmount = $pricing['grandTotal'];

        $orderId = $this->orderModel->getOrderByCartId($cartId);

        if (!$orderId) {
            $orderId = $this->orderModel->createOrder($cartId, $address, $status, $paymentType, $totalAmount);
        }

        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['product_id'];
            $quantity = $cartItem['cartItemQuantity'];
            $unitPrice = $cartItem['price'];
            $totalPrice = $cartItem['total'];
            $this->orderItemsModel->orderItems($orderId, $productId, $quantity, $unitPrice, $totalPrice);

            $this->productModel->updateProductQuantity($productId, $quantity);
        }

        $this->cartItemModel->clearCart($cartId);

        header("Location: /order/detail");
    }

    public function displayOrder()
    {
        $cartId = $this->cartModel->getOrCreateCart($this->userid);
        $orderId = $this->orderModel->getOrderByCartId($cartId);
        $orderItems = $this->orderItemsModel->displayOrder($orderId);
        View::render('view_order', ['orderItems' => $orderItems]);
    }
}
