<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Adapters\ResponseAdapter;
use Illuminate\Http\JsonResponse;
use Exception;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $products = $this->productService->getAllPaginate();

            return ResponseAdapter::success($products, __('messages.product_fetch_failed'));
        } catch (Exception $e) {
            return ResponseAdapter::error(__('messages.product_fetch_failed'));
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->productService->getProductById($id);

            return ResponseAdapter::success($product);
        } catch (Exception $e) {
            return ResponseAdapter::error(__('messages.product_not_found'));
        }
    }

    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $payload = $request->validated();
            $product = $this->productService->createProduct($payload);

            return ResponseAdapter::success($product, __('messages.product_created'), 201);
        } catch (Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }

    public function update(ProductRequest $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validated();
            $this->productService->updateProduct($id, $validated);

            return ResponseAdapter::success([], __('messages.product_updated'));
        } catch (Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->productService->deleteProduct($id);

            return ResponseAdapter::success([], __('messages.product_deleted'));
        } catch (Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }

    public function allProducts(): JsonResponse
    {
        try {
            $products = $this->productService->getAllProducts();

            return ResponseAdapter::success($products);
        } catch (Exception $e) {
            return ResponseAdapter::error(__('messages.product_fetch_failed'));
        }
    }
}
