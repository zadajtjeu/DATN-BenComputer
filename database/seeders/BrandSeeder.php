<?php

namespace Database\Seeders;

use File;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/datas/brands.json");
        $brands = json_decode($json);

        foreach ($brands as $brand) {
            $inserted = Brand::create([
                "name" => $brand->name,
                "slug" => Str::slug($brand->name),
            ]);

            $inserted->logo()->create([
                'name' => basename($brand->logo),
                'url' => $brand->logo,
            ]);
        }
    }
}
