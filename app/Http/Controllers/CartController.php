<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Services\CartService;
use App\Adapters\ResponseAdapter;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function addToCart(AddToCartRequest $request, int $productId): JsonResponse
    {
        try {
            $payload = $request->validated();
            $userId = Auth::id();

            $this->cartService->addToCart($userId, $productId, $payload['quantity']);
            $carts = $this->cartService->getCartItems($userId);

            return ResponseAdapter::success($carts, __('messages.added_to_cart'));
        } catch (\Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }

    public function cartList(): JsonResponse
    {
        try {
            $cartItems = $this->cartService->getCartItems(Auth::id());

            return ResponseAdapter::success($cartItems, __('messages.cart_retrieved'));
        } catch (\Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }

    public function removeFromCart(int $productId): JsonResponse
    {
        try {
            $this->cartService->removeFromCart(Auth::id(), $productId);

            return ResponseAdapter::success(null, __('messages.removed_from_cart'));
        } catch (\Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }
}
