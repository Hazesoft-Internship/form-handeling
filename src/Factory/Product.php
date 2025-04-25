<?php

namespace App\Factory;

interface Product
{
    public static function getDisount(int $orderQuantity): float|int;
    public static function getShippingCharge(int $quantity): float|int;
    public static function getPaymentMethod(): array;
}
