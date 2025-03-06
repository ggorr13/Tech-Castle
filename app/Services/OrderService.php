<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderService
{
    public function __construct(private OrderRepositoryInterface $orderRepository)
    {
    }

    public function createOrder(array $data): Order
    {
        return $this->orderRepository->createOrder($data);
    }

    public function getUserOrders($user)
    {
        return $user->orders()->with('products')->get();
    }
}
