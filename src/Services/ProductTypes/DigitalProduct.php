<?php

namespace Hazesoft\Formhandeling\Services\ProductTypes;


class DigitalProduct extends AbstractProduct
{

    public function calculateTotal(): float
    {
        $total = $this->quantity * $this->price;
        if ($this->quantity >= 12) {
            $total *= 0.8;
        } elseif ($this->quantity >= 6) {
            $total *= 0.9;
        }
        return $total;
    }
}
