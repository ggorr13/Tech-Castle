<?php


namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Services\ProductTypes\ProductTypeFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class ProductService
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function getAllPaginate(): LengthAwarePaginator
    {
        return $this->productRepository->getAllPaginate();
    }

    public function getProductById(int $id): Product
    {
        return $this->productRepository->getById($id);
    }

    public function createProduct(array $data): Product
    {
        if (empty($data['type'])) {
            throw new InvalidArgumentException('Product type is required.');
        }

        $strategy = ProductTypeFactory::create($data['type']);

        $data['price'] = $strategy->calculatePrice($data);

        if (!empty($data['image'])) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data): bool
    {
        $product = $this->productRepository->getById($id);

        if (empty($data['type'])) {
            throw new InvalidArgumentException('Product type is required.');
        }

        $strategy = ProductTypeFactory::create($data['type']);
        $data['price'] = $strategy->calculatePrice($data);

        if (!empty($data['image'])) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        }

        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id): bool
    {
        $product = $this->productRepository->getById($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $this->productRepository->delete($id);
    }

    public function uploadImage(UploadedFile $image): string
    {
        // Store the image in the 'public/products' directory
        return $image->store('products', 'public');
    }

    public function isValidQuantity(int $productId, int $requestedQuantity): bool
    {
        return $this->productRepository->checkProductQuantity($productId, $requestedQuantity);
    }
}
