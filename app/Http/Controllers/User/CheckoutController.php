<?php

namespace App\Http\Controllers\User;

use Exception;
use Carbon\Carbon;
use App\Enums\VoucherStatus;
use App\Enums\VoucherCondition;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Shipping\ShippingRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use App\Repositories\Province\ProvinceRepositoryInterface;
use App\Repositories\District\DistrictRepositoryInterface;
use App\Repositories\Ward\WardRepositoryInterface;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    protected $productRepo;

    protected $voucherRepo;

    protected $userRepo;

    protected $shippingRepo;

    protected $orderRepo;

    protected $orderItemRepo;

    protected $provinceRepo;

    protected $districtRepo;

    protected $wardRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        VoucherRepositoryInterface $voucherRepo,
        UserRepositoryInterface $userRepo,
        ShippingRepositoryInterface $shippingRepo,
        OrderRepositoryInterface $orderRepo,
        OrderItemRepositoryInterface $orderItemRepo,
        ProvinceRepositoryInterface $provinceRepo,
        DistrictRepositoryInterface $districtRepo,
        WardRepositoryInterface $wardRepo
    ) {
        $this->productRepo = $productRepo;
        $this->voucherRepo = $voucherRepo;
        $this->userRepo = $userRepo;
        $this->shippingRepo = $shippingRepo;
        $this->orderRepo = $orderRepo;
        $this->orderItemRepo = $orderItemRepo;
        $this->provinceRepo = $provinceRepo;
        $this->districtRepo = $districtRepo;
        $this->wardRepo = $wardRepo;
    }

    public function index(Request $request)
    {
        $check_update = true;
        $check_update_message = [];
        $check_voucher = true;
        $check_voucher_message = [];
        $subtotals = 0;
        $coupon = 0;
        $totals = 0;

        $products = [];
        $voucher =[];

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            $products = $this->productRepo
                ->getAllIn(array_keys($cart));

            foreach ($products as $product) {
                if ($product->quantity >= $cart[$product->id]->selected_quantity) {
                    $price = $product->promotion_price;
                    if (empty($product->promotion_price)) {
                        $price = $product->price;
                    }

                    $subtotals += $price * $cart[$product->id]->selected_quantity;
                } else {
                    $check_update = false;
                    $check_update_message[111] = __('A product was sold out. Please remove it from your cart!');
                    $cart[$product->id]->selected_quantity = 0;
                }

                if ($product->price != $cart[$product->id]->price ||
                    $product->promotion_price != $cart[$product->id]->promotion_price
                ) {
                    $check_update = false;
                    $check_update_message[222] = __('A product was updated. Please reload your cart!');
                }

                $cart[$product->id]->price = $product->price;
                $cart[$product->id]->promotion_price = $product->promotion_price;
                $cart[$product->id]->quantity = $product->quantity;
                $cart[$product->id]->sold = $product->sold;
            }

            $request->session()->put('cart', $cart);
        }

        if ($request->session()->has('voucher')) {
            $voucher = $this->voucherRepo->find($request->session()->get('voucher')->id);


            if (empty($voucher)) {
                $check_voucher = false;
                $check_voucher_message[] = __('Voucher not exist');
            } elseif ($subtotals <= 0) {
                $request->session()->forget('voucher');
            } else {
                if ($voucher->quantity <= 0) {
                    $check_voucher = false;
                    $check_voucher_message[] = __('Voucher has been used up');
                }
                if ($voucher->status != VoucherStatus::AVAILABLE) {
                    $check_voucher = false;
                    $check_voucher_message[] = __('Voucher has not active');
                }

                $timeNow = Carbon::now();
                $endDate = Carbon::parse($voucher->end_date);

                if ($timeNow->gte($endDate)) {
                    $check_voucher = false;
                    $check_voucher_message[] = __('Voucher has expired');
                }

                if ($this->userRepo->checkAuthVoucherUsed($voucher->id)) {
                    $check_voucher = false;
                    $check_voucher_message[] = __('You have used this voucher before');
                }

                if ($check_voucher) {
                    if ($voucher->condition == VoucherCondition::PERCENT) {
                        $coupon = $subtotals * $voucher->value / 100;
                    } elseif ($voucher->condition == VoucherCondition::AMOUNT) {
                        $coupon = $voucher->value;
                    }

                    if ($subtotals < $coupon) {
                        $coupon = $subtotals;
                    }
                } else {
                    $request->session()->forget('voucher');
                }
            }

            if ($check_voucher) {
                if ($voucher->condition == VoucherCondition::PERCENT) {
                    $coupon = $subtotals * $voucher->value / 100;
                } elseif ($voucher->condition == VoucherCondition::AMOUNT) {
                    $coupon = $voucher->value;
                }

                if ($subtotals < $coupon) {
                    $coupon = $subtotals;
                }
            } else {
                $request->session()->forget('voucher');
            }
        }

        $totals = $subtotals - $coupon;

        $messages = array_merge($check_update_message, $check_voucher_message);

        return view('users.checkout', [
            'products' => $products,
            'voucher' => $voucher,
            'subtotals' => $subtotals,
            'coupon' => $coupon,
            'totals' => $totals,
            'messages' => $messages,
        ]);
    }

    public function addOrder(CheckoutRequest $request)
    {
        if (!$request->session()->has('cart')) {
            return redirect()->route('cart.index');
        }

        $check_update = true;
        $check_update_message = [];
        $check_voucher = true;
        $check_voucher_message = [];
        $subtotals = 0;
        $coupon = 0;
        $totals = 0;

        $products = [];
        $voucher =[];

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            $products = $this->productRepo
                ->getAllIn(array_keys($cart));

            foreach ($products as $product) {
                if ($product->quantity >= $cart[$product->id]->selected_quantity) {
                    $price = $product->promotion_price;
                    if (empty($product->promotion_price)) {
                        $price = $product->price;
                    }

                    $subtotals += $price * $cart[$product->id]->selected_quantity;
                } else {
                    $check_update = false;
                    $check_update_message[111] = __('A product was sold out. Please remove it from your cart!');
                    $cart[$product->id]->selected_quantity = 0;
                }

                if ($product->price != $cart[$product->id]->price ||
                    $product->promotion_price != $cart[$product->id]->promotion_price
                ) {
                    $check_update = false;
                    $check_update_message[222] = __('A product was updated. Please reload your cart!');
                }

                $cart[$product->id]->price = $product->price;
                $cart[$product->id]->promotion_price = $product->promotion_price;
                $cart[$product->id]->quantity = $product->quantity;
                $cart[$product->id]->sold = $product->sold;
            }

            $request->session()->put('cart', $cart);
        }

        if ($request->session()->has('voucher')) {
            $voucher = $this->voucherRepo->find($request->session()->get('voucher')->id);


            if (empty($voucher)) {
                $check_voucher = false;
                $check_voucher_message[] = __('Voucher not exist');
            } elseif ($subtotals <= 0) {
                $request->session()->forget('voucher');
            } else {
                if ($voucher->quantity <= 0) {
                    $check_voucher = false;
                    $check_voucher_message[] = __('Voucher has been used up');
                }
                if ($voucher->status != VoucherStatus::AVAILABLE) {
                    $check_voucher = false;
                    $check_voucher_message[] = __('Voucher has not active');
                }

                $timeNow = Carbon::now();
                $endDate = Carbon::parse($voucher->end_date);

                if ($timeNow->gte($endDate)) {
                    $check_voucher = false;
                    $check_voucher_message[] = __('Voucher has expired');
                }

                if ($this->userRepo->checkAuthVoucherUsed($voucher->id)) {
                    $check_voucher = false;
                    $check_voucher_message[] = __('You have used this voucher before');
                }

                if ($check_voucher) {
                    if ($voucher->condition == VoucherCondition::PERCENT) {
                        $coupon = $subtotals * $voucher->value / 100;
                    } elseif ($voucher->condition == VoucherCondition::AMOUNT) {
                        $coupon = $voucher->value;
                    }

                    if ($subtotals < $coupon) {
                        $coupon = $subtotals;
                    }
                } else {
                    $request->session()->forget('voucher');
                }
            }

            if ($check_voucher) {
                if ($voucher->condition == VoucherCondition::PERCENT) {
                    $coupon = $subtotals * $voucher->value / 100;
                } elseif ($voucher->condition == VoucherCondition::AMOUNT) {
                    $coupon = $voucher->value;
                }

                if ($subtotals < $coupon) {
                    $coupon = $subtotals;
                }
            } else {
                $request->session()->forget('voucher');
            }
        }

        $totals = $subtotals - $coupon;

        if ($check_voucher && $check_update) {
            // Insert to db
            $cart = $request->session()->get('cart');

            try {
                // Begin transaction
                DB::beginTransaction();
                // Insert shipping address
                $shipping = $this->shippingRepo->create(array_merge(
                    $request->validated(),
                    [
                        'user_id' => Auth::id(),
                    ],
                ));

                // Insert order to get order_id
                $order = $this->orderRepo->create([
                    'user_id' => Auth::id(),
                    'order_code' => Str::random(8),
                    'total_price' => $subtotals,
                    'promotion_price' => $totals,
                    'status' => OrderStatus::NEW_ORDER,
                    'note' => $request->note,
                    'payment' => $request->session()->has('pay') ? $request->session()->get('pay') : 'COD',
                    'shipping_id' => $shipping->id,
                ]);

                // Voucher
                if (!empty($voucher)) {
                    // Insert voucher to order
                    $this->orderRepo->update($order->id, [
                        'voucher_id' => $voucher->id,
                    ]);

                    // Update quantity
                    $this->voucherRepo->updateQuantity($voucher->id);
                }

                // Insert order_items
                foreach ($products as $product) {
                    if ($product->quantity < $cart[$product->id]->selected_quantity ||
                        $cart[$product->id]->selected_quantity <= 0
                    ) {
                        DB::rollBack();

                        return redirect()->route('cart.index')
                            ->with('error', __('Some items have been updated or do not exist'));
                    }

                    // Insert order items
                    $this->orderItemRepo->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'buying_price' => $product->promotion_price > 0
                            ? $product->promotion_price : $product->price,
                        'quantity' => $cart[$product->id]->selected_quantity,
                    ]);

                    // Update product quantity
                    $product_quantity_update = -$cart[$product->id]->selected_quantity;
                    $product_sold_update = $cart[$product->id]->selected_quantity;

                    $this->productRepo->updateProductQuantity(
                        $product->id,
                        $product_quantity_update,
                        $product_sold_update
                    );
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                return redirect()->back()
                    ->with('error', __('There are some errors. Please try again later!'));
            }

            // Delete session
            $request->session()->forget('cart');
            $request->session()->forget('voucher');

            // check method
            if ($request->session()->has('pay')) {
                // Render link vnpay

                $vnp_TxnRef = $order->id;
                $vnp_OrderInfo = "Order#$order->order_code";
                $vnp_OrderType = "Laptop";
                $vnp_Locale = config('app.locale');
                $vnp_IpAddr = $request->ip();

                $inputData = array(
                    "vnp_Version" => "2.0.0",
                    "vnp_TmnCode" => env('VNP_TMN_CODE'),
                    "vnp_Amount" => $totals,
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
            } else {
                return view('users.checkoutsuccess', [
                    'order' => $order,
                ]);
            }
        }

        return redirect()->route('cart.index');
    }

    public function vnpayReturn(Request $request)
    {
        $order = $this->orderRepo->findOrFail($request->vnp_TxnRef);

        if ($request->vnp_ResponseCode != '00') {
            return abort(404);
        }

        // Check lại với vnpay
        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_Command" => "querydr",
            "vnp_TmnCode" => env('VNP_TMN_CODE'),
            "vnp_TxnRef" => $request->vnp_TxnRef,
            "vnp_OrderInfo" => $request->vnp_OrderInfo,
            "vnp_TransDate" => $request->vnp_PayDate,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_IpAddr" => $request->ip(),
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

        $vnp_Url = env('VNP_QUERYDR') . "?" . $query;
        if (env('VNP_HASH_SECRET')) {
            $vnpSecureHash = hash('sha256', env('VNP_HASH_SECRET') . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }

        $result = Http::get($vnp_Url);

        $array_result = [];
        parse_str($result, $array_result);

        if (isset($array_result['vnp_TransactionStatus']) &&
            $array_result['vnp_TransactionStatus'] == '00'
        ) {
            //Update order payment status
            $this->orderRepo->updateOrderPaymentStatus($order->id, PaymentStatus::SUCCESS);

            return view('users.checkoutsuccess', [
                'order' => $order,
            ]);
        }

        return abort(404);
    }

    public function getProvinces()
    {
        $all = $this->provinceRepo->getAll();

        return response()->json($all);
    }

    public function getDistricts($id)
    {
        $all = $this->districtRepo->where('province_id', $id);

        return response()->json($all);
    }

    public function getWards($id)
    {
        $all = $this->wardRepo->where('district_id', $id);

        return response()->json($all);
    }
}
