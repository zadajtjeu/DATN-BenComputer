<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rate' => $this->faker->numberBetween(3,5),
            'comment' => $this->faker->sentence(),
            'product_id' => Product::factory(),
            'order_item_id' => OrderItem::factory(),
            'user_id' => User::factory(),
        ];
    }
}
