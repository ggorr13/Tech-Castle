<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CartRepository implements CartRepositoryInterface
{
    public function getUserCart(User $user): Collection
    {
        return $user->cart()->get();
    }

    public function findCartItem(User $user, int $productId): ?Product
    {
        return $user->cart()->where('product_id', $productId)->first();
    }

    public function addToCart(User $user, Product $product, int $quantity): bool
    {
        $user->cart()->attach($product->id, [
            'quantity' => $quantity,
            'price' => $product->price,
        ]);

        return true;
    }

    public function updateCartItemQuantity(Product $cartItem, int $quantity): bool
    {
        $cartItem->pivot->quantity += $quantity;
        return $cartItem->pivot->save();
    }

    public function removeFromCart(User $user, int $productId): bool
    {
        return $user->cart()->detach($productId);
    }
}
