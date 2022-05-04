<?php

namespace App\Http\Controllers\User;

use DB;
use Exception;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            ->getFullAuthOrderWithPaginate(config('pagination.per_page'));

        return view('users.orders.orderhistory', [
            'orders' => $orders,
        ]);
    }

    public function getDetails($id)
    {
        $orderDetails = $this->orderRepo
            ->getFullAuthOrderDetails($id);

        return view('users.orders.details', [
            'orderDetails' => $orderDetails,
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $order = $this->orderRepo->getFullAuthOrderDetails($id);

        if ($order->status != OrderStatus::NEW_ORDER &&
            $order->status != OrderStatus::IN_PROCCESS) {
            return redirect()->back()->with('error', __('Failed to cancel this order'));
        }

        $order_update = [
            'status' => OrderStatus::CANCELED,
        ];

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

    public function repayment(Request $request, $id)
    {
        $order = $this->orderRepo->getFullAuthOrderDetails($id);

        // Render link vnpay

        $vnp_TxnRef = $order->id;
        $vnp_OrderInfo = "Order#$order->order_code";
        $vnp_OrderType = "Laptop2";
        $vnp_Locale = config('app.locale');
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => env('VNP_TMN_CODE'),
            "vnp_Amount" => $order->promotion_price,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => route('checkout.vnpayReturn'),
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        ksort($inputData);

        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }


        $vnp_Url = env('VNP_URL') . "?" . $query;
        if (env('VNP_HASH_SECRET')) {
            $vnpSecureHash = hash('sha256', env('VNP_HASH_SECRET') . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function switchCOD($id)
    {
        $order = $this->orderRepo->getFullAuthOrderDetails($id);

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
}
