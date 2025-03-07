<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Services\CartService;
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
            $quantity = $payload['quantity'];
            $userId = Auth::id();

            $this->cartService->addToCart($userId, $productId, $quantity);
            $carts = $this->cartService->getCartItems($userId);

            return response()->json(['message' => 'Added to cart successfully', 'carts' => $carts]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cartList(): JsonResponse
    {
        try {
            $cartItems = $this->cartService->getCartItems(Auth::id());

            return response()->json(['cart' => $cartItems]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function removeFromCart(int $productId): JsonResponse
    {
        try {
            $this->cartService->removeFromCart(Auth::id(), $productId);

            return response()->json(['message' => 'Removed from cart successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
