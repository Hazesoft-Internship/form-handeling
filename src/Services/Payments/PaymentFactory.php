<?php

namespace ECommerce\Services\Payments;

use Exception;

class PaymentFactory
{
    public static function getInstance(string $paymentType): object
    {
        $paymentMethods = require __DIR__ . '/../../Config/paymentmethods.php';
        if (!array_key_exists($paymentType, $paymentMethods)) {
            throw new Exception("Unknown Payment Type: $paymentType");
        }
        return $paymentMethods[$paymentType];
    }
}
