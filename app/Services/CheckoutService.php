<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Auth;

class CheckoutService
{

    public function __construct(
        private ProductService $productService,
        private OrderService   $orderService
    )
    {
    }

    /**
     * @throws Exception
     */
    public function checkout(): Order
    {
        $user = Auth::user();
        // Get the user's cart
        $carts = $user->cart;

        $totalPrice = 0;

        foreach ($carts as $product) {
            $quantity = $product->pivot->quantity;

            // Check if the product has enough stock
            if (!$this->productService->isValidQuantity($product->id, $quantity)) {
                throw new Exception("Product {$product->name} does not have enough stock.");
            }

            // Calculate the total price with tax
            $priceWithTax = $product->price_with_tax * $quantity;
            $totalPrice += $priceWithTax;
        }

        $order = $this->orderService->createOrder([
            'user_id' => $user->id,
            'total_price' => $totalPrice
        ]);

        // Attach products to the order
        foreach ($carts as $product) {
            $order->products()->attach($product->id, [
                'quantity' => $product->pivot->quantity,
                'price_with_tax' => $product->price_with_tax,
            ]);
        }

        // Clear the user's cart
        $user->cart()->detach();

        return $order;
    }
}
