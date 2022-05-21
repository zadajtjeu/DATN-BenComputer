<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    public function editProfile()
    {
        $user = Auth::user();

        return view('users.profile.info', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $this->userRepo->update($user->id, [
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->back()
            ->with('success', __('Update profile successfully'));
    }

    public function editPassword()
    {
        $user = Auth::user();

        return view('users.profile.changepass', compact('user'));
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $userPassword = $user->password;
        if (!Hash::check($request->current_password, $userPassword)) {
            return back()->withErrors(['current_password' => __('Old password not match')]);
        }
        $this->userRepo->update($user->id, [
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile')
            ->with('success', __('Update password successfully'));
    }
}
