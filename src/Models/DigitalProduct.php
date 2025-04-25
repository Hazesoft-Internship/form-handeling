<?php

namespace Hazesoft\Backend\Models;

use Hazesoft\Backend\Interfaces\ProductInterface;
use Hazesoft\Backend\Models\Product;
use Exception;

class DigitalProduct implements ProductInterface
{
    public function applyDiscount($cartItems, $totalPrice)
    {
        try {
            $discountAmount = 0;
            foreach ($cartItems as $item) {
                if ($item["product_type"] == "digital") {
                    if (($item["added_quantity"] >= 6) && ($item["added_quantity"]) < 12) {
                        $discount = ($item["item_grand_total"] * 10) / 100;
                        $discountAmount += $discount;
                    } elseif ($item["added_quantity"] >= 12) {
                        $discount = ($item["item_grand_total"] * 20) / 100;
                        $discountAmount += $discount;
                    }
                }
            }
            $totalPrice = $totalPrice - $discountAmount;
            return $totalPrice;
        } catch (Exception $exception) {
            echo ($exception->getMessage());
        }
    }
    public function addShippingCost($cartItems, $totalPrice)
    {
        return 0;
    }
}
