<?php

namespace App\Models\Product;

use App\Models\Product\Product;

class PhysicalProduct extends Product
{

    function __construct(string $name,  int $quantity, int $price, string $description, int $user_id)
    {
        parent::__construct(
            $name,
            $quantity,
            $price,
            $user_id,
            $description,
        );
    }

    public function getType(): string
    {
        return "physical";
    }

    public function paymentMethod(): array
    {
        return ["esewa", "Cash On delivery"];
    }

    public static function physicalDiscount(int $quantity)
    {

        if ($quantity >= 5) {
            return "shipping cost added 100rs";
        }
        if ($quantity >= 10) {
            return "shipping cost added 200rs";
        }
    }
}
