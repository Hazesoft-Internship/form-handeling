<?php


namespace App\Factory;

use App\Factory\PhysicalProduct;


class ProductFactory
{


    public function createProduct($type)
    {
        return match ($type) {
            'physical' => new PhysicalProduct(),
            'digital' =>  new DigitalProduct(),
        };
    }
}
