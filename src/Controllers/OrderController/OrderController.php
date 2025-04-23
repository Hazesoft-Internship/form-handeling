<?php

namespace ECommerce\Controllers\OrderController;

use ECommerce\Controllers\ModelParentClass;
use ECommerce\Services\Payments\PaymentFactory;

class OrderController extends ModelParentClass
{

    public function calculateTaxAndGrandTotal(): array
    {
        $userID = $this->session->get("userID");
        $cartItems = $this->cartItems->getCartItemsDetail($userID);
        
        $physicalProduct = PaymentFactory::getInstance("Physical");
        $digitalProduct = PaymentFactory::getInstance("Digital");

        $physicalProductQuantity = 0;
        $digitalProductQuantity = 0;

        foreach ($cartItems as $item) {
            $item["type"] === "Physical" ? $physicalProductQuantity += $item["quantity"] :
                $digitalProductQuantity += $item["quantity"];
        }

        $shippingCost = $physicalProduct->addShipCost($physicalProductQuantity);
        $discountPercentage = $digitalProduct->calculateDiscount($digitalProductQuantity);

        $subtotal = array_reduce($cartItems, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        $discount = ($subtotal * $discountPercentage) / 100;
        $tax = $subtotal * 0.13;
        $grandTotal = $subtotal + $tax + $shippingCost - $discount;

        return [$cartItems, $tax, $grandTotal];
    }

    public function getOrderPage()
    {
        [$cartItems, $tax, $grandTotal] = $this->calculateTaxAndGrandTotal();
        $typesInCart = array_unique(array_map(fn($item) => $item['type'], $cartItems));
        $availablePaymentMethod = [];

        foreach ($typesInCart as $type) {
            $paymentInstance = PaymentFactory::getInstance($type);
            $methods = $paymentInstance->getPaymentMethods();
            $availablePaymentMethod = array_merge($availablePaymentMethod, $methods);
        }

        if (count($typesInCart) > 1) {
            $availablePaymentMethod = array_filter($availablePaymentMethod, fn($type) => $type !== "COD");
        }

        return require __DIR__ . '/../../Views/checkout.html';
    }

    public function handleProductDeduction(): void
    {
        $userID = $this->session->get("userID");
        $cartItems = $this->cartItems->getCartItemsDetail($userID);

        $productQuantity = [];
        foreach ($cartItems as $item) {
            $productQuantity[$item['productID']] = $item['quantity'];
        }

        foreach ($productQuantity as $productID => $quantity) {
            $this->product->deductProductQuantity($productID, $quantity);
        }
    }

    public function handleAddOrderItems(int $cartID, int $userID): void
    {
        $orderID = $this->order->getOrderID($cartID);
        $products = $this->cartItems->getCartItemsDetail($userID);
        foreach ($products as $product) {
            $this->orderItems->addOrderItems($orderID['id'], $product['productID'], $product['quantity'], ($product['quantity'] * $product['price']));
        }
    }

    public function handleCreateOrder(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cartID = $_GET['cartID'];
            $userID = $this->session->get("userID");
            $address = $_POST['address'];
            $paymentType = $_POST['paymentType'];
            [, $tax, $grandTotal] = $this->calculateTaxAndGrandTotal();

            $createOrderResult = $this->order->createOrder($cartID, $address, $paymentType, (int)$tax, $grandTotal);
            $this->handleAddOrderItems($cartID, $userID);

            if ($createOrderResult) {
                $this->handleProductDeduction();
                $this->cartItems->deleteAllCartItems($cartID);
                header("Location: /orderHistory");
            }
            echo "Failed to place order";
        }
    }

    public function getOrderHistoryPage(): void
    {
        $userID = $this->session->get("userID");
        $orderHistory = $this->order->getOrderHistory($userID);
        require_once __DIR__ . '/../../Views/order-history.html';
    }
}
