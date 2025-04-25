<?php

namespace Hazesoft\Backend\Interfaces;

interface ProductInterface
{
    public function addShippingCost($cartItems, $totalPrice);
    public function applyDiscount($cartItems, $totalPrice);
}