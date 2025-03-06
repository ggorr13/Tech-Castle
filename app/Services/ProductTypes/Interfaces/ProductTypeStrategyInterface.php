<?php

namespace App\Services\ProductTypes\Interfaces;

interface ProductTypeStrategyInterface
{
    public function calculatePrice(array $data): float;
}
