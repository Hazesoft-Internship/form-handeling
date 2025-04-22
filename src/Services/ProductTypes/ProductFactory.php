<?php

namespace Hazesoft\Formhandeling\Services\ProductTypes;

use InvalidArgumentException;

class ProductFactory
{
    public static function create(string $type, float $unitPrice, int $qty): AbstractProduct
    {
        return match (strtolower($type)) {
            'digital' => new DigitalProduct($unitPrice, $qty),
            'physical' => new PhysicalProduct($unitPrice, $qty),
            default => throw new InvalidArgumentException("Unknown type {$type}"),
        };
    }
}
