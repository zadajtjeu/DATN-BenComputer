<?php
namespace App\Repositories\Province;

use App\Repositories\BaseRepository;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Province::class;
    }
}
