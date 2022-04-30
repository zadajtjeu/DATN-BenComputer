<?php

namespace Database\Factories;

use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'province_id' => Province::factory(),
            'district_id' => District::factory(),
            'ward_id' => Ward::factory(),
            'user_id' => User::factory(),
        ];
    }
}
