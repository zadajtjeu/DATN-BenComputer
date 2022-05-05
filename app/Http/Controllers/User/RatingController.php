<?php

namespace App\Http\Controllers\User;

use DB;
use Exception;
use App\Enums\OrderStatus;
use App\Enums\RateStatus;
use App\Http\Requests\Rating\RatingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use App\Repositories\Rating\RatingRepositoryInterface;

class RatingController extends Controller
{
    protected $productRepo;

    protected $orderRepo;

    protected $orderItemRepo;

    protected $ratingRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        OrderRepositoryInterface $orderRepo,
        OrderItemRepositoryInterface $orderItemRepo,
        RatingRepositoryInterface $ratingRepo
    ) {
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
        $this->orderItemRepo = $orderItemRepo;
        $this->ratingRepo = $ratingRepo;
    }

    public function index($id)
    {
        $orderItem = $this->orderItemRepo->findOrFail($id);

        if (!Gate::allows('add-rating', $orderItem->order)) {
            return redirect()->back()
                ->with('error', __('Can not access'));
        }

        if ($orderItem->order->status != OrderStatus::COMPLETED) {
            return redirect()->back()
                ->with('error', __('Can not access'));
        }

        return view('users.orders.rating', [
            'orderItem' => $orderItem,
        ]);
    }

    public function create(RatingRequest $request, $id)
    {
        $orderItem = $this->orderItemRepo->findOrFail($id);

        if (!Gate::allows('add-rating', $orderItem->order)) {
            return redirect()->back()
                ->with('error', __('Can not access'));
        }

        if ($orderItem->order->status != OrderStatus::COMPLETED) {
            return redirect()->back()
                ->with('error', __('Can not access'));
        }
        try {
            DB::beginTransaction();

            $this->orderItemRepo->forceUpdate($id, [
                'rate_status' => RateStatus::BLOCK,
            ]);

            $rating = $this->ratingRepo->updateOrCreate(
                [
                    'order_item_id' => $id,
                    'product_id' => $orderItem->product_id,
                    'user_id' => Auth::id(),
                ],
                [
                    'rate' => $request->rate,
                    'comment' => $request->comment,
                ]
            );

            // Update avg rate
            $avg_rate = $this->ratingRepo->avgRate($orderItem->product_id);
            $avg_rate = round($avg_rate * 2) / 2; // Round to the Nearest 0.5 (1.0, 1.5, 2.0, 2.5, etc.)
            $this->productRepo->forceUpdate(
                $orderItem->product_id,
                [
                    'avg_rate' => $avg_rate,
                ]
            );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->back()
            ->with('success', __('Rate success'));
    }
}
