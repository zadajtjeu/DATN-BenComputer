<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Voucher;
use App\Models\Shipping;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_code' => Str::random(8),
            'total_price' => 10000000,
            'status' => OrderStatus::getRandomValue(),
            'payment' => 'COD',
            'user_id' => User::factory(),
            'proccess_user_id' => User::factory(),
            'voucher_id' => Voucher::factory(),
            'shipping_id' => Shipping::factory(),
        ];
    }
}
