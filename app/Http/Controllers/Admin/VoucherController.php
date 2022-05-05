<?php

namespace App\Http\Controllers\Admin;

use DB;
use Exception;
use Carbon\Carbon;
use App\Enums\VoucherStatus;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Repositories\Voucher\VoucherRepositoryInterface;

class VoucherController extends Controller
{
    protected $voucherRepo;

    public function __construct(
        VoucherRepositoryInterface $voucherRepo
    ) {
        $this->voucherRepo = $voucherRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers = $this->voucherRepo
            ->paginate(config('pagination.per_page'));

        return view('admins.vouchers.index', [
            'vouchers' => $vouchers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVoucherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVoucherRequest $request)
    {
        try {
            $this->voucherRepo->create([
                'code' => $request->code,
                'value' => $request->value,
                'condition' => $request->condition,
                'title' => $request->title,
                'start_date' => Carbon::parse($request->start_date),
                'end_date' => Carbon::parse($request->end_date),
                'quantity' => $request->quantity,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.vouchers.index')
                ->with('success', __('Created Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voucher = $this->voucherRepo->findOrFail($id);

        return view('admins.vouchers.edit', [
            'voucher' => $voucher,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVoucherRequest  $request
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVoucherRequest $request, $id)
    {
        try {
            $voucher = $this->voucherRepo->update($id, $request->validated());
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.vouchers.index')
            ->with('success', __('Updated Successfully'));
    }

    public function block($id)
    {
        try {
            $voucher = $this->voucherRepo->forceUpdate($id, [
                'status' => VoucherStatus::BLOCK,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->back()
            ->with('success', __('Updated Successfully'));
    }

    public function unblock($id)
    {
        try {
            $voucher = $this->voucherRepo->forceUpdate($id, [
                'status' => VoucherStatus::AVAILABLE,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->back()
            ->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->voucherRepo->delete($id);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.vouchers.index')
            ->with('success', __('Deleted Successfully'));
    }
}
