<?php

namespace Hazesoft\Formhandeling\Services\ProductTypes;

class PhysicalProduct extends AbstractProduct
{

    public function calculateTotal(): float
    {
        $total = $this->quantity * $this->price;
        if ($this->quantity >= 10) {
            $total += 200;
        } elseif ($this->quantity >= 5) {
            $total += 100;
        }
        return $total;
    }
}
