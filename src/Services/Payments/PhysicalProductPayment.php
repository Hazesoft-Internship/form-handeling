<?php

namespace ECommerce\Services\Payments;

use ECommerce\Services\Payments\PaymentMethod;

class PhysicalProductPayment implements PaymentMethod
{
    public function getPaymentMethods(): array
    {
        return ["COD", "ESewa"];
    }

    public function addShipCost(int $productQuantity): int
    {
        if ($productQuantity >= 10) return 200;
        elseif ($productQuantity >= 5) return 100;
        else return 0;
    }
}
