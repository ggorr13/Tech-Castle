<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
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

            return response()->json(['products' => $products], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->productService->getProductById($id);

            return response()->json(['product' => $product], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $payload = $request->validated();
            $product = $this->productService->createProduct($payload);

            return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update(ProductRequest $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validated();
            $this->productService->updateProduct($id, $validated);

            return response()->json(['message' => 'Product updated successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->productService->deleteProduct($id);

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function allProducts(): JsonResponse
    {
        try {
            $products = $this->productService->getAllProducts();

            return response()->json(['products' => $products], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
