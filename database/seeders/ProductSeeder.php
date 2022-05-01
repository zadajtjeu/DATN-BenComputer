<?php

namespace Database\Seeders;

use File;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/datas/products.json");
        $products = json_decode($json);

        foreach ($products as $product) {
            $inserted_product = Product::create([
                "id" => $product->id,
                "title" => $product->title,
                "content" => $product->content,
                "specifications" => $product->description,
                "slug" => Str::slug(Str::limit($product->slug, 100)),
                "quantity" => $product->quantity,
                "sold" => $product->sold,
                "promotion_price" => $product->retail_price >= $product->retail_price ? 0 : $product->retail_price,
                "price" => $product->original_price,
                "avg_rate" => $product->avg_rate,
                "category_id" => $product->category_id,
            ]);

            $inserted_product->images()->create([
                'name' => basename($product->image),
                'url' => $product->image,
            ]);
        }
    }
}
