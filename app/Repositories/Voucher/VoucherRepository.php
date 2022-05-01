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
}
