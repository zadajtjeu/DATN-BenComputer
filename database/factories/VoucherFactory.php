<?php

namespace Database\Factories;

use App\Enums\VoucherStatus;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'value' => $this->faker->numberBetween(50000, 1000000),
            'title' => $this->faker->sentence(),
            'start_date' => now(),
            'end_date' => now(),
            'quantity' => $this->faker->randomNumber(5, false),
            'used' => 0,
            'status' => VoucherStatus::getRandomValue(),
        ];
    }
}
