<?php
namespace App\Repositories\Shipping;

use App\Repositories\BaseRepository;

class ShippingRepository extends BaseRepository implements ShippingRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Shipping::class;
    }
}
