<?php

namespace Hazesoft\Formhandeling\Services\ProductTypes;

abstract class AbstractProduct
{
    protected float $price;
    protected int $quantity;
    public function __construct($price, $quantity)
    {
        $this->price = $price;
        $this->quantity = $quantity;
    }

    abstract public function calculateTotal(): float;
}
