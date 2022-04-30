<?php

namespace Database\Seeders;

use File;
use App\Models\PostType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post_types = [
            [
                'id' => 1,
                'name' => 'Tin khuyến mãi',
                'slug' => Str::slug('Tin khuyến mãi'),
                'parent_id' => null,
            ],
            [
                'id' => 2,
                'name' => 'Tin game',
                'slug' => Str::slug('Tin game'),
                'parent_id' => null,
            ],
            [
                'id' => 3,
                'name' => 'Tin công nghệ',
                'slug' => Str::slug('Tin công nghệ'),
                'parent_id' => null,
            ],
            [
                'id' => 4,
                'name' => 'Wiki',
                'slug' => Str::slug('Wiki'),
                'parent_id' => null,
            ],
            [
                'id' => 5,
                'name' => 'Cẩm nang công nghệ',
                'slug' => Str::slug('Cẩm nang công nghệ'),
                'parent_id' => null,
            ],
            [
                'id' => 6,
                'name' => 'Thủ thuật phần mềm',
                'slug' => Str::slug('Thủ thuật phần mềm'),
                'parent_id' => 5,
            ],
            [
                'id' => 7,
                'name' => 'Thủ thuật máy tính',
                'slug' => Str::slug('Thủ thuật máy tính'),
                'parent_id' => 5,
            ],
            [
                'id' => 8,
                'name' => 'Thủ thuật Internet',
                'slug' => Str::slug('Thủ thuật Internet'),
                'parent_id' => 5,
            ],
            [
                'id' => 9,
                'name' => 'Thủ thuật văn phòng',
                'slug' => Str::slug('Thủ thuật văn phòng'),
                'parent_id' => 5,
            ],
        ];

        PostType::insert($post_types);
    }
}
