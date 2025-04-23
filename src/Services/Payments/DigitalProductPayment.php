<?php

namespace ECommerce\Services\Payments;

use ECommerce\Services\Payments\PaymentMethod;

class DigitalProductPayment implements PaymentMethod
{
    public function getPaymentMethods(): array
    {
        return ["Khalti"];
    }

    public function calculateDiscount(int $productQuantity): int
    {
        if ($productQuantity >= 12) return 20;
        elseif ($productQuantity >= 6) return 10;
        else return 0;
    }
}
