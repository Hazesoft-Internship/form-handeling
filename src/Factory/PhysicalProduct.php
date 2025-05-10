<?php

namespace App\Factory;

use App\Factory\Product;



class PhysicalProduct implements Product
{

    public static function getDisount(int $orderQuantity): float|int
    {
        return 0;
    }

    public static function getShippingCharge(int $quantity): float|int
    {
        if ($quantity >= 5 && $quantity < 10) {
            return 100;
        }

        if ($quantity >= 10) {
            return 200;
        }

        return 0;
    }

    public static function getPaymentMethod(): array
    {
        return ["esewa", "cash on delivery"];
    }
}
