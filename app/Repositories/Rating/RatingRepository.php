<?php
namespace App\Repositories\Rating;

use App\Repositories\BaseRepository;

class RatingRepository extends BaseRepository implements RatingRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Rating::class;
    }

    public function updateOrCreate(
        $attributes1 = [],
        $attributes2 = []
    ) {
        return $this->model->updateOrCreate(
            $attributes1,
            $attributes2
        );
    }

    public function avgRate($product_id)
    {
        return $this->model
            ->where('product_id', $product_id)
            ->avg('rate');
    }
}
