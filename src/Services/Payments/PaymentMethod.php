<?php

namespace ECommerce\Services\Payments;

interface PaymentMethod
{
    public function getPaymentMethods(): array;
}
