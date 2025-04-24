<?php

namespace Lattefront\FormHandeling\FactoryDesign;

use Exception;
use Lattefront\FormHandeling\Model\Digitalproduct;
use Lattefront\FormHandeling\Model\Physicalproduct;

class ProductFactory
{

    public static function createTypes($type)
    {
        return match ($type) {
            "physical" => new Physicalproduct(),
            "digital" => new Digitalproduct(),
            default => throw new Exception("Product type  not found"),
        };
    }
}
