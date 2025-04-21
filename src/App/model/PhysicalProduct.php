<?php
namespace App\model;
use App\model\ProductInterface;

class PhysicalProduct implements ProductInterface
{

    public function displayAllProducts()
    {

    }

    public function calculateProduct($price, $quantity)
    {
        if($quantity >= 10) {
            return $price + 200;
        } elseif($quantity >= 5) {
            return $price + 100;
        } else {
            return $price;
        }
    }

    public function paymentMethodOfProducts()
    {
        
    }


}