<?php
namespace App\model;

interface ProductInterface
{
    public function displayAllProducts();
    public function calculateProduct($quantity, $price);
    public function paymentMethodOfProducts();
}