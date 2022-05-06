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
        $order = auth()->user()->orders()->where('voucher_id', $voucher_id)->first();

        if (!empty($order->id)) {
            return true;
        }

        return false;
    }

    public function getListByRole($role, $paginate)
    {
        return $this->model->where('role', $role)
            ->orderBy('created_at', 'DESC')
            ->paginate($paginate);
    }
}
