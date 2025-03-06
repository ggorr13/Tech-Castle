<?php

namespace App\Services\ProductTypes;

use App\Services\ProductTypes\Interfaces\ProductTypeStrategyInterface;
use InvalidArgumentException;

class ProductTypeFactory
{
    public static function create(string $type): ProductTypeStrategyInterface
    {
        return match ($type) {
            'physical' => new PhysicalProductStrategy(),
            'digital' => new DigitalProductStrategy(),
            default => throw new InvalidArgumentException('Invalid product type.')
        };
    }
}
