<?php

namespace Lattefront\FormHandeling\FactoryDesign;

use Exception;
use Lattefront\FormHandeling\Model\Digitalproduct;
use Lattefront\FormHandeling\Model\Physicalproduct;
use Lattefront\FormHandeling\Model\ProductInterface;

class ProductFactory{
    
    public static function createTypes ( array $type) {
        print_r($type);
       
        $products = [];
        foreach ($type as $t) {
            $products[] = match ($t) {
            "physical" => new Physicalproduct(),
            "digital" => new Digitalproduct(),
            default => throw new Exception("Product type '$t' not found"),
            };
        }
        return $products;
    }
}