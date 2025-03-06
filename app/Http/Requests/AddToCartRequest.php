<?php

namespace App\Http\Requests;

use App\Services\ProductService;
use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{

    public function __construct(private ProductService $productService)
    {
        parent::__construct();
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $productId = $this->route('productId');
                    $product = $this->productService->getProductById($productId);

                    if (empty($product)) {
                        return $fail('The selected product does not exist.');
                    }

                    if ($value > $product->quantity) {
                        return $fail('The requested quantity exceeds available stock.');
                    }
                },
            ],
        ];
    }
}
