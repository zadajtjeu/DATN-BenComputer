<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'content' => $this->faker->paragraph(),
            'specifications' => $this->faker->paragraph(),
            'slug' => Str::slug($title, '-'),
            'quantity' => 1000,
            'sold' => 0,
            'price' => $this->faker->numberBetween(800000, 1000000),
            'promotion_price' => $this->faker->numberBetween(500000, 700000),
            'avg_rate' => $this->faker->numberBetween(3,5),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
        ];
    }
}
