<?php
namespace App\Repositories\Order;

use App\Repositories\BaseRepository;
use App\Enums\OrderStatus;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Order::class;
    }

    public function countNewOrder()
    {
        return $this->model->where('status', OrderStatus::NEW_ORDER)->count();
    }
}
