<?php
namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function countNewOrder();

    public function getFullAuthOrderWithPaginate($paginate);

    public function getFullAuthOrderDetails($id);

    public function getOrderByStatusPaginate($status, $paginate);

    public function getTotalOrdersWeekForMonth($monday, $nextMonday);

    public function getRevenueMonth($year);
}
