<?php
namespace App\model;
use App\model\PhysicalProduct;
use App\model\abstract\AbstractProductCreator;

class PhysicalProductFactory extends AbstractProductCreator
{
    public function productCreate()
    {
        return new PhysicalProduct();
    }
}