<?php
namespace App\Repositories\Order;

use DB;
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

    public function getOrderByStatusPaginate($status, $paginate)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'DESC')
            ->paginate($paginate);
    }

    public function getRevenueMonth($year)
    {
        return $this->model->where('status', OrderStatus::COMPLETED)->whereYear('created_at', $year)
            ->selectRaw('month(created_at) as m, year(created_at) as y,sum(promotion_price) as sum')
            ->groupBy(DB::raw('month(created_at),year(created_at)'))
            ->pluck('sum', 'm')->toArray();
    }

    public function getTotalOrdersWeekForMonth($monday, $nextMonday)
    {
        return $this->model->where('status', OrderStatus::COMPLETED)->whereBetween('created_at', [$monday, $nextMonday])
            ->selectRaw('year(created_at) as y,count(id) as countId')
            ->groupBy(DB::raw('year(created_at)'))
            ->pluck('countId');
    }
}
