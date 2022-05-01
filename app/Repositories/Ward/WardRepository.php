<?php
namespace App\Repositories\Ward;

use App\Repositories\BaseRepository;

class WardRepository extends BaseRepository implements WardRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Ward::class;
    }
}
