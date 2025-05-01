<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::query()->inRandomOrder()->first()->id,
            'product_name' => fake()->word(),
            'qty' => fake()->randomNumber(),
            'price' => fake()->randomNumber(),
            'subtotal' => fake()->randomNumber(),
        ];
    }
}
