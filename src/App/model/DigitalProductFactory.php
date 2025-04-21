<?php

namespace App\model;
use App\model\DigitalProduct;
use App\model\abstract\AbstractProductCreator;

class DigitalProductFactory extends AbstractProductCreator
{
    public function productCreate()
    {
        return new DigitalProduct();
    }
}