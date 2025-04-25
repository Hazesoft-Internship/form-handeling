<?php

namespace App\Factory;

use App\Factory\Product;



class DigitalProduct implements Product
{



    public static function getDisount(int $orderQuantity): float|int
    {
        if ($orderQuantity >= 6 && $orderQuantity < 12) {

            return 10;
        }

        if ($orderQuantity >= 12) {

            return 20;
        }

        return 0;
    }

    public static  function getShippingCharge(int $quantity): float|int
    {
        return 0;
    }

    public static function getPaymentMethod(): array
    {
        return ["Khalti"];
    }
}
