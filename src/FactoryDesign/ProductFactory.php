<?php

namespace Lattefront\FormHandeling\FactoryDesign;

use Exception;
use Lattefront\FormHandeling\Model\Digitalproduct;
use Lattefront\FormHandeling\Model\Physicalproduct;
use Lattefront\FormHandeling\Model\ProductInterface;

class ProductFactory
{

    public static function createTypes($product): ProductInterface
    {
        return match ($product["productTypes"]) {
            "physical" => new Physicalproduct($product),
            "digital" => new Digitalproduct($product),
            default => throw new Exception("Product type  not found"),
        };
    }
}

