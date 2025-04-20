<?php

namespace Hazesoft\Backend\Controllers\OrderController;

use Exception;
use Hazesoft\Backend\Models\CartItems;
use Hazesoft\Backend\Models\User;
use Hazesoft\Backend\Services\Session;

class OrderController
{
    private $user;
    private $session;
    private $cart;

    public function __construct()
    {
        $this->user = new User();
        $this->session = Session::getInstance();
        $this->cart = new CartItems();
    }
    public function getCheckoutPage()
    {
        $viewData = $this->handleCheckoutData();
        extract($viewData);
        return require_once(__DIR__ . '/../../Views/order-checkout.php');
    }

    public function handleCheckoutData()
    {
        [$cartItems, $totalPrice] = $this->handleCartDetailsData();

        $userId = $this->session->getSession("userId");
        $address = $this->user->getUserAddress($userId);

        $productTypes = $this->cart->getProductType($userId);

        // get payment methods
        $paymentMethods = $this->getPaymentMethods($productTypes);
        
        return [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'address' => $address,
            'paymentMethods' => $paymentMethods
        ];
    }

    public function getPaymentMethods($productTypes)
    {
        try {
            $typeArray = [];

            foreach($productTypes as $key => $type){
                $typeArray[] = $type["type"];
            }

            if ((in_array("physical", $typeArray)) && (in_array("digital", $typeArray))) {
                $paymentMethods = ["eSewa", "Khalti"];
            } elseif (in_array("physical", $typeArray)) {
                $paymentMethods = ["Cash on Delivery", "eSewa"];
            } elseif (in_array("digital", $typeArray)) {
                $paymentMethods = ["Khalti"];
            } else {
                $paymentMethods = [];
            }

            return $paymentMethods;

        } catch (Exception $exception) {
            echo ($exception->getMessage());
            return null;
        }
    }

    public function handleCartDetailsData()
    {
        try {
            $userId = $this->session->getSession("userId");

            $cartItems = $this->cart->getCartItems($userId);

            $totalPrice = array_reduce($cartItems, [$this, 'addPrice'], 0);

            return [$cartItems, $totalPrice];

        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
        }
    }
    public function addPrice($carry, $item2)
    {
        return $carry + $item2["item_total_price"];
    }
}
