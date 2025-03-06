<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(): Collection
    {
        return Product::all();
    }

    public function getAllPaginate(): LengthAwarePaginator
    {
        return Product::query()->paginate(10);
    }

    public function getById(int $id): ?Product
    {
        return Product::query()->findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::query()->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return Product::query()->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return Product::destroy($id);
    }

    public function checkProductQuantity(int $productId, int $quantity): bool
    {
        $product = Product::find($productId);

        return $product && $product->quantity >= $quantity;
    }
}
