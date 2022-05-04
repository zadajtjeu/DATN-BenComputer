<?php
namespace App\Repositories\Order;

use App\Repositories\BaseRepository;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Auth;

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
        $order->payment_status = $status;

        if ($order->save()) {
            return true;
        }

        return false;
    }

    public function getFullAuthOrderWithPaginate($paginate)
    {
        return Auth::user()->orders()
            ->orderBy('created_at', 'DESC')
            ->paginate($paginate);
    }

    public function getFullAuthOrderDetails($id)
    {
        return Auth::user()->orders()
            ->with('orderItems')
            ->findOrFail($id);
    }
}
