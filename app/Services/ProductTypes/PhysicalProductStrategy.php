<?php

namespace App\Services\ProductTypes;

use App\Services\ProductTypes\Interfaces\ProductTypeStrategyInterface;

class PhysicalProductStrategy implements ProductTypeStrategyInterface
{
    public function calculatePrice(array $data): float
    {
        $basePrice = $data['price'];
        $weight = $data['weight'];

        // Additional cost based on weight (e.g., +2% per kg)
        $extraCost = $weight * 0.02 * $basePrice;

        return round($basePrice + $extraCost, 2);
    }
}
