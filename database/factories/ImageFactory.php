<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imageable = $this->imageable();

        return [
            'url' => $this->faker->imageUrl(640, 480, 'animals', true),
            'imageable_id' => $imageable::factory(),
            'imageable_type' => $imageable,
        ];
    }

    public function imageable()
    {
        return $this->faker->randomElement([
            Post::class,
            Product::class,
        ]);
    }
}
