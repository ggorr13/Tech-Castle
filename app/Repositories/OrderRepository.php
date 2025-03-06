<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{

    public function createOrder(array $data): Order
    {
        return Order::query()->create($data);
    }
}
