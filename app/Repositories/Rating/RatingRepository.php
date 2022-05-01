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
}
