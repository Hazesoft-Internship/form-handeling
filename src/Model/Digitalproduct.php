<?php

namespace Lattefront\FormHandeling\Model;

use Lattefront\FormHandeling\Model\ProductInterface;

class Digitalproduct implements ProductInterface
{

    public static function  getPaymentMethod(): array
    {
        return [(string) "Khalti"];
    }

    public static function getDiscountedPrice($quantity, $price): int
    {

        if ($quantity >= 6 & $quantity < 12) {
           
            $price -= $price * 10/100;            
            
            return $price;
        }
        if ($quantity >= 12) {
            $price -= $price * 20/100;
            return $price;
        } else {
            return $price;
        }
    }
    public static function getProductTypes(): string
    {
        return "Digital";
    }
}
