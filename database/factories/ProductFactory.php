<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 5, 100),
            'quantity' => $this->faker->numberBetween(1, 50),
            'type' => $this->faker->randomElement(['physical', 'digital']),
            // Based on generated type the other properties could be null or something else
            // For example we would not have a weight, width... for digital products
            // but will have download_url
            'price_with_tax' => null,
            'weight' => $this->faker->randomFloat(2, 0.1, 10),
            'width' => $this->faker->randomFloat(2, 1, 100),
            'height' => $this->faker->randomFloat(2, 1, 100),
            'length' => $this->faker->randomFloat(2, 1, 100),
            'download_url' => null,
        ];
    }
}
