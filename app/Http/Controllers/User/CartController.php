<?php

namespace App\Http\Controllers\User;

use Exception;
use Carbon\Carbon;
use App\Enums\VoucherStatus;
use App\Enums\VoucherCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\VoucherApplyRequest;

class CartController extends Controller
{
    protected $productRepo;

    protected $voucherRepo;

    protected $userRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        UserRepositoryInterface $userRepo,
        VoucherRepositoryInterface $voucherRepo
    ) {
        $this->voucherRepo = $voucherRepo;
        $this->productRepo = $productRepo;
        $this->userRepo = $userRepo;
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

        return view('users.cart', [
            'products' => $products,
            'voucher' => $voucher,
            'subtotals' => $subtotals,
            'coupon' => $coupon,
            'totals' => $totals,
            'messages' => $messages,
        ]);
    }

    public function add(Request $request, $product_id)
    {
        $product = $this->productRepo->getWithImages($product_id);

        if ($product->quantity < 1) {
            return redirect()->back()
                ->with('error', __('This product is sold out'));
        }

        if ($request->session()->get('cart') == null) {
            $product->selected_quantity = 1;

            $cart[$product->id] = $product;

            $request->session()->put('cart', $cart);
        } else {
            $cart = $request->session()->get('cart');

            if (isset($cart[$product->id])) {
                if ($cart[$product->id]->selected_quantity + 1 > $product->quantity) {
                    return redirect()->back()
                        ->with('warning', __('You already have :selected_quantity quantity in cart.'
                            . ' Unable to add selected quantity to cart as it would exceed your purchase limit.', [
                                'selected_quantity' => $cart[$product->id]['selected_quantity'],
                        ]));
                }

                $cart[$product->id]->selected_quantity += 1;
            } else {
                $product->selected_quantity = 1;
                $cart[$product->id] = $product;
            }

            $request->session()->put('cart', $cart);
        }

        return redirect()->back()
            ->with('success', __('This product has been added to your cart'));
    }

    public function minus(Request $request, $product_id)
    {
        $check = false;
        $messages = '';

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');

            if (!empty($cart[$product_id])) {
                $product = $this->productRepo->getWithImages($product_id);

                if ($product->quantity < $cart[$product_id]->selected_quantity) {
                    unset($cart[$product_id]);
                    $check = false;
                    $messages = __('This product is sold out') . ' ' . __('and has been removed from your cart');
                } elseif ($cart[$product_id]->selected_quantity == 1) {
                    unset($cart[$product_id]);
                } else {
                    $cart[$product_id]->selected_quantity -= 1;
                }

                if (count($cart) == 0) {
                    $request->session()->forget('cart');
                } else {
                    $request->session()->put('cart', $cart);
                }
            } else {
                $check = true;
                $messages = __('The cart does not have this product');
            }
        } else {
            $check = true;
            $messages = __('Cart empty');
        }

        if ($check) {
            return redirect()->back()
                ->with('error', $messages);
        }

        return redirect()->back()
            ->with('success', __('Updated Successfully'));
    }

    public function delete(Request $request, $id)
    {
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');

            if (isset($cart[$id])) {
                unset($cart[$id]);

                if (count($cart) == 0) {
                    $request->session()->forget('cart');
                } else {
                    $request->session()->put('cart', $cart);
                }

                return redirect()->back()
                    ->with('success', __('Deleted Successfully'));
            }

            return redirect()->back()
                ->with('warning', __('The cart does not have this product'));
        }

        return redirect()->back()
            ->with('error', __('Cart empty'));
    }

    public function voucherApply(VoucherApplyRequest $request)
    {
        if ($request->session()->has('voucher')) {
            $request->session()->forget('voucher');
        }

        $check_voucher = true;
        $check_voucher_message = [];

        $voucher = $this->voucherRepo->where('code', $request->code)->first();

        if (empty($voucher)) {
            $check_voucher = false;
            $check_voucher_message[] = __('Voucher not exist');
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
            $startDate = Carbon::parse($voucher->start_date);

            if ($timeNow->gte($endDate)) {
                $check_voucher = false;
                $check_voucher_message[] = __('Voucher has expired');
            }

            if ($timeNow->lte($startDate)) {
                $check_voucher = false;
                $check_voucher_message[] = __('This voucher cannot be used at this time');
            }

            if ($this->userRepo->checkAuthVoucherUsed($voucher->id)) {
                $check_voucher = false;
                $check_voucher_message[] = __('You have used this voucher before');
            }
        }

        if ($check_voucher) {
            $request->session()->put('voucher', $voucher);

            return redirect()->back()
                ->with('message_success', __('Appy voucher successfully'));
        } else {
            return redirect()->back()
                ->with('message_error', $check_voucher_message[0]);
        }
    }

    public function voucherDetele(Request $request)
    {
        if ($request->session()->has('voucher')) {
            $request->session()->forget('voucher');
        }

        return redirect()->back()
            ->with('message_success', __('Deleted Successfully'));
    }

    public function checkoutMethod(Request $request)
    {
        $request->session()->forget('pay');

        if ($request->has('method') && $request->method == 'online') {
            $pay = $request->session()->get('pay');

            $request->session()->put('pay', 'online');
        }

        return redirect()->route('checkout.form');
    }
}
