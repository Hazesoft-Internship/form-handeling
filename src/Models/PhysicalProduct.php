<?php

namespace Hazesoft\Backend\Models;

use Hazesoft\Backend\Interfaces\ProductInterface;
use Exception;

class PhysicalProduct implements ProductInterface
{
    public function getPaymentMethod()
    {
        return ["Cash on Delivery", "eSewa"];
    }

    public function addShippingCost($cartItems, $totalPrice)
    {
        try {
            $shippingCost = 0;
            foreach ($cartItems as $item) {
                if($item["product_type"] == "physical"){
                    if (($item["added_quantity"] >= 5) && ($item["added_quantity"]) < 10) {
                        $shippingCost += 100;
                    } elseif ($item["added_quantity"] >= 10) {
                        $shippingCost += 200;
                    }
                }
            }
            $totalPrice = $totalPrice + $shippingCost;
            return $totalPrice;
        } catch (Exception $exception) {
            echo ($exception->getMessage());
            return 0;
        }
    }
    public function applyDiscount($cartItems, $totalPrice)
    {
        return 0;
    }
}
