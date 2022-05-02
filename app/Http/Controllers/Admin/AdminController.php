<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class AdminController extends Controller
{
    protected $productRepo;
    protected $orderRepo;
    protected $userRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        OrderRepositoryInterface $orderRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
        $this->userRepo = $userRepo;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totals = [
            'order_total' => $this->orderRepo->count(),
            'new_order_total' => $this->orderRepo->countNewOrder(),
            'product_total' => $this->productRepo->count(),
            'user_total' => $this->userRepo->count(),
        ];

        return view('admins.dashboard', [
            'totals_overview' => $totals,
        ]);
    }
}
