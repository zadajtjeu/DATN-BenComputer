<?php

namespace App\Http\Controllers\Admin;

use DB;
use Exception;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;

class OrderController extends Controller
{
    protected $productRepo;

    protected $orderRepo;

    protected $voucherRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        OrderRepositoryInterface $orderRepo,
        VoucherRepositoryInterface $voucherRepo
    ) {
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
        $this->voucherRepo = $voucherRepo;
    }

    public function index()
    {
        $orders = $this->orderRepo
            ->paginate(config('pagination.per_page'));

        return view('admins.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function getNewOrders()
    {
        $orders = $this->orderRepo
            ->getOrderByStatusPaginate(OrderStatus::NEW_ORDER, config('pagination.per_page'));

        return view('admins.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function getProcessOrder()
    {
        $orders = $this->orderRepo
            ->getOrderByStatusPaginate(OrderStatus::IN_PROCCESS, config('pagination.per_page'));

        return view('admins.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function getShippingOrder()
    {
        $orders = $this->orderRepo
            ->getOrderByStatusPaginate(OrderStatus::IN_SHIPPING, config('pagination.per_page'));

        return view('admins.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function getDetails($id)
    {
        $orderDetails = $this->orderRepo
            ->findOrFail($id);

        return view('admins.orders.details', [
            'orderDetails' => $orderDetails,
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $order = $this->orderRepo->findOrFail($id);

        if ($order->status == OrderStatus::COMPLETED) {
            return redirect()->back()->with('error', __('Failed to cancel this order'));
        }

        $order_update = [
            'status' => OrderStatus::CANCELED,
            'proccess_user_id' => Auth::id(),
        ];

        if ($order->payment == 'online' && $order->payment_status != PaymentStatus::SUCCESS) {
            $order_update['payment_status'] = PaymentStatus::FAIL;
        }

        if ($request->reason_canceled) {
            $order_update['note'] = $request->reason_canceled;
        }

        try {
            // Begin transaction
            DB::beginTransaction();
            // Update product quantity when cancel
            foreach ($order->orderItems as $item) {
                // Update product quantity
                $product_quantity_update = $item->quantity;
                $product_sold_update = -$item->quantity;

                $this->productRepo->updateProductQuantity(
                    $item->product_id,
                    $product_quantity_update,
                    $product_sold_update
                );
            }

            if (!empty($order->voucher_id)) {
                $this->voucherRepo->updateQuantityRevert($order->voucher_id);
                // Delete voucher from this order
                $order_update['voucher_id'] = null;
            }

            $this->orderRepo->forceUpdate($order->id, $order_update);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', __('There are some errors. Please try again later!'));
        }

        return redirect()->back()->with('success', __('Order is canceled'));
    }

    public function switchCOD($id)
    {
        $order = $this->orderRepo->findOrFail($id);

        if ($order->payment != 'online'
            && $order->payment_status != PaymentStatus::PROCCESSING
        ) {
            return redirect()->back()->with('error', __('Update failed'));
        }

        if ($this->orderRepo->update($order->id, ['payment' => 'COD'])) {
            return redirect()->back()->with('success', __('Order is updated'));
        }

        return redirect()->back()->with('error', __('Update failed'));
    }

    public function update(Request $request, $id)
    {
        $order = $this->orderRepo->findOrFail($id);

        if (!in_array($request->status, OrderStatus::getValues())) {
            return redirect()->back()->with('error', __('Status is invalid'));
        }
        if ($order->status == OrderStatus::CANCELED) {
            return redirect()->back()->with('error', __('Failed to cancel this order'));
        }

        $order_update = [
            'status' => $request->status,
            'proccess_user_id' => Auth::id(),
        ];

        try {
            $this->orderRepo->forceUpdate($order->id, $order_update);
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', __('There are some errors. Please try again later!'));
        }

        return redirect()->back()->with('success', __('Order is updated'));
    }

    public function print($id)
    {
        $order = $this->orderRepo->findOrFail($id);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('admins.orders.invoice', ['order' => $order]);

        return $pdf->stream();
    }
}
