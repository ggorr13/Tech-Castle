<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
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

            return response()->json([
                'message' => 'Order placed successfully.',
                'order' => $order->load('products'),
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 400);
        }
    }
}
