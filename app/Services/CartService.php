<?php

namespace App\Services;

use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Collection;

class CartService
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private ProductService $productService,
        private UserService $userService
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function addToCart(int $userId, int $productId, int $quantity): void
    {
        $user = $this->userService->find($userId);
        $product = $this->productService->getProductById($productId);

        if (!$this->productService->isValidQuantity($productId, $quantity)) {
            throw new \Exception('Requested quantity exceeds available stock.');
        }

        $existingCartItem = $this->cartRepository->findCartItem($user, $productId);

        if (!empty($existingCartItem)) {
            $this->cartRepository->updateCartItemQuantity($existingCartItem, $quantity);
        } else {
            $this->cartRepository->addToCart($user, $product, $quantity);
        }
    }

    public function getCartItems(int $userId): Collection
    {
        $user = $this->userService->find($userId);
        $cartItems = $this->cartRepository->getUserCart($user);

        return $cartItems->map(function ($cartItem) {
            return [
                'product_id' => $cartItem->id,
                'quantity' => $cartItem->pivot->quantity,
                'price' => $cartItem->pivot->price,
                'total' => $cartItem->pivot->quantity * $cartItem->pivot->price,
                'name' => $cartItem->name,
                'image' => $cartItem->image
            ];
        });
    }

    public function removeFromCart(int $userId, int $productId): bool
    {
        $user = $this->userService->find($userId);
        return $this->cartRepository->removeFromCart($user, $productId);
    }
}
