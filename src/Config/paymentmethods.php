<?php

use ECommerce\Services\Payments\DigitalProductPayment;
use ECommerce\Services\Payments\PhysicalProductPayment;

return [
    "Physical" => new PhysicalProductPayment(),
    "Digital" => new DigitalProductPayment()
];
