<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function checkAuthVoucherUsed($voucher_id)
    {
        $order = auth()->user()->orders()->find($voucher_id);

        if (!empty($order)) {
            return true;
        }

        return false;
    }
}
