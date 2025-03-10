<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use App\Adapters\ResponseAdapter;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    public function __construct(private CheckoutService $checkoutService)
    {
    }

    public function checkout(): JsonResponse
    {
        try {
            $order = $this->checkoutService->checkout();

            return ResponseAdapter::success(
                $order->load('products'),
                __('messages.order_placed'),
                201
            );
        } catch (\Exception $e) {
            return ResponseAdapter::error(__('messages.checkout_failed'));
        }
    }
}
