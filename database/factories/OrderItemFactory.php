<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Order;
use App\Enums\RateStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => $this->faker->randomNumber(5, true),
            'buying_price' => $this->faker->numberBetween(),
            'rate_status' => RateStatus::ALLOW,
            'order_id' => Order::factory(),
        ];
    }
}
