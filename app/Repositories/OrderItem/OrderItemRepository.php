<?php
namespace App\Repositories\OrderItem;

use App\Repositories\BaseRepository;

class OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\OrderItem::class;
    }
}
