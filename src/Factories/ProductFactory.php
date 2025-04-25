<?php

namespace Hazesoft\Backend\Factories;

use Exception;
use Hazesoft\Backend\Interfaces\ProductInterface;
use Hazesoft\Backend\Models\DigitalProduct;
use Hazesoft\Backend\Models\PhysicalProduct;

class ProductFactory
{
    public static function createProductByType($type) : ProductInterface | null
    {
        try {
            return match ($type) {
                "physical" => new PhysicalProduct(),
                "digital" => new DigitalProduct(),
                default => throw new Exception("Invalid product type")
            };
        } catch (Exception $exception){
            echo ($exception->getMessage());
            return null;
        }
    }
}