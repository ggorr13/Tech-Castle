<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Adapters\ResponseAdapter;
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
                return ResponseAdapter::error(__('messages.no_orders'), 404);
            }

            return ResponseAdapter::success($orders, __('messages.order_history_retrieved'));

        } catch (Exception $e) {
            return ResponseAdapter::error(__('messages.order_fetch_failed'));
        }
    }
}
