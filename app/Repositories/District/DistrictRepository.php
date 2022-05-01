<?php
namespace App\Repositories\District;

use App\Repositories\BaseRepository;

class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\District::class;
    }
}
