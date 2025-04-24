<?php

namespace Lattefront\FormHandeling\Model;

use Lattefront\FormHandeling\Model\ProductInterface;

class Physicalproduct implements ProductInterface
{

    public static function getPaymentMethod(): array
    {
        return [(string) "COD", (string) "Esewa"];
    }

    public  static function  getDiscountedPrice($quantity, $price): int
    {
        if ($quantity >= 5 && $quantity < 10) {
            $price += 100;
        }
        if ($quantity >= 10) {
            $price += 200;
        }
        return $price;
    }

    public static function getProductTypes(): string
    {
        return "Physical";
    }
}
