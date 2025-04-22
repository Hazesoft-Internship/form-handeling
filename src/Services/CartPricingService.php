<?php

namespace Hazesoft\Formhandeling\Services;

use Hazesoft\Formhandeling\Services\ProductTypes\ProductFactory;

class CartPricingService
{
    public static function calculate(array $cartItems): array
    {
        $total = 0;
        $productType = [];
        $paymentMethods = [];

        foreach ($cartItems as &$item) {
            $product = ProductFactory::create($item['types'], $item['price'], $item['cartItemQuantity']);
            $item['total'] = $product->calculateTotal();
            $total += $item['total'];
            $productType[] = $item['types'];
        }
        $productType = array_unique($productType);

        if (in_array("digital", $productType) && in_array("physical", $productType)) {
            $paymentMethods = ['esewa', 'khalti'];
        } elseif (in_array("digital", $productType)) {
            $paymentMethods = ['khalti'];
        } elseif (in_array("physical", $productType)) {
            $paymentMethods = ['esewa', 'COD'];
        } else {
            echo "Invalid payment option";
        }

        $tax = $total * 0.13;
        $grandTotal = $total + $tax;

        return [
            'cartItems' => $cartItems,
            'total' => $total,
            'tax' => $tax,
            'grandTotal' => $grandTotal,
            'paymentMethods' => $paymentMethods
        ];
    }
}
