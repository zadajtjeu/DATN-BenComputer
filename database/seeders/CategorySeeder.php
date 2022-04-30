<?php

namespace Database\Seeders;

use File;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/datas/categories.json");
        $categories = json_decode($json);

        foreach ($categories as $category) {
            Category::create([
                "id" => $category->id,
                "parent_id" => $category->parent_id,
                "name" => $category->name,
                "slug" => $category->slug,
            ]);
        }
    }
}
