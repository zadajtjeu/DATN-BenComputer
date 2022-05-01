<?php
namespace App\Repositories\Product;

use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Product::class;
    }

    public function getProductDetails($slug, $id)
    {
        $result = $this->model
            ->where([
                'id' => $id,
                'slug' => $slug,
            ])
            ->firstOrFail();

        return $result;
    }
}
