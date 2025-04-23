<?php

namespace App\Models\Product;

use App\Models\Product\Product;

class DigitalProduct extends Product
{

    function __construct(
        string $name,
        int $quantity,
        int $price,
        int $user_id,
        string $description
    ) {
        parent::__construct(
            $name,
            $quantity,
            $price,
            $user_id,
            $description
        );
    }

    public function getType(): string
    {
        return "digital";
    }

    // public function getPaymentMethod(): string
    // {
    //     return {};
    // }

    public static function digitalDiscount(int $quantity)
    {

        if ($quantity >= 6) {

            return "discount 10%";
        }

        if ($quantity >= 12) {

            return " discount 20%";
        }
    }
}
