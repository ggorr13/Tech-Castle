<?php

namespace App\Services\ProductTypes;

use App\Services\ProductTypes\Interfaces\ProductTypeStrategyInterface;

class DigitalProductStrategy implements ProductTypeStrategyInterface
{
    public function calculatePrice(array $data): float
    {
        return ($data['price'] ?? 0) * 0.9; // Apply a 10% discount for digital products
    }
}
