<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface CartRepositoryInterface
{
    public function getUserCart(User $user): Collection;

    public function findCartItem(User $user, int $productId): ?Product;

    public function addToCart(User $user, Product $product, int $quantity): bool;

    public function updateCartItemQuantity(Product $cartItem, int $quantity): bool;

    public function removeFromCart(User $user, int $productId): bool;
}
