<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'description' => $this->faker->paragraph(),
            'slug' => Str::slug($this->faker->sentence()),
            'post_type_id' => PostType::factory(),
            'user_id' => User::factory(),
        ];
    }
}
