<?php
namespace App\Repositories\Voucher;

use App\Repositories\BaseRepository;

class VoucherRepository extends BaseRepository implements VoucherRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Voucher::class;
    }

    public function updateQuantity($voucher_id)
    {
        $voucher = $this->find($voucher_id);

        $voucher->quantity -= 1;
        $voucher->used += 1;

        $voucher->save();
    }
}
