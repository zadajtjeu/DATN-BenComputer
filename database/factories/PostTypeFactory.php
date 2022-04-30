<?php

namespace Database\Factories;

use App\Models\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(3);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
