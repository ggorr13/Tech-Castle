<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function __construct(private OrderService $orderService)
    {

    }

    public function userOrderHistory(): JsonResponse
    {
        try {
            $orders = $this->orderService->getUserOrders(Auth::user());

            if ($orders->isEmpty()) {
                return response()->json(['message' => 'No orders found.',], 404);
            }

            return response()->json(['orders' => $orders], 200);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 400);
        }
    }
}
