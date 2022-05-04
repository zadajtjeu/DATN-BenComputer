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

    public function updateOrderPaymentStatus($order_id, $status)
    {
        $order = $this->find($order_id);
        $order->status = $status;

        if ($order->save()) {
            return true;
        }

        return false;
    }
}
