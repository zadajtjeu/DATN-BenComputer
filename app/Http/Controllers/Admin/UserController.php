<?php

namespace App\Http\Controllers\Admin;

use DB;
use Exception;
use Carbon\Carbon;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateRoleUserRequest;
use App\Http\Requests\User\UpdatePasswordUserRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepo
            ->paginate(config('pagination.per_page'));

        return view('admins.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listUser()
    {
        $users = $this->userRepo
            ->getListByRole(UserRole::USER, config('pagination.per_page'));

        return view('admins.users.listusers', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepo->findOrFail($id);

        return view('admins.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userRepo->update($id, $request->validated());
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.users.index')
            ->with('success', __('Updated Successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(UpdatePasswordUserRequest $request, $id)
    {
        try {
            $user = $this->userRepo->update($id, [
                'password' => Hash::make($request->password),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.users.index')
            ->with('success', __('Updated Successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function editRole(UpdateRoleUserRequest $request, $id)
    {
        try {
            $user = $this->userRepo->forceUpdate($id, [
                'role' => $request->role,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.users.index')
            ->with('success', __('Updated Successfully'));
    }


    /**
     * Block the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockUser($id)
    {
        $user = $this->userRepo->findorfail($id);

        if (Auth::user()->role == UserRole::MANAGER &&
            ($user->role == UserRole::MANAGER)
        ) {
            return redirect()->back()->with('error', __('Can not change same role'));
        }

        if ($user->role == UserRole::ADMIN) {
            return redirect()->back()->with('error', __('Can not block admin'));
        }

        if ($this->userRepo->forceUpdate($user->id, ['status' => UserStatus::BANNED])) {
            return redirect()->route('admin.users.index')->with('success', __('User is locked'));
        }

        return redirect()->back()->with('error', __('Failed to block user'));
    }

    /**
     * Block the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unblockUser($id)
    {
        $user = $this->userRepo->findorfail($id);

        if (Auth::user()->role == UserRole::MANAGER &&
            ($user->role == UserRole::MANAGER)
        ) {
            return redirect()->back()->with('error', __('Can not change same role'));
        }

        if ($this->userRepo->forceUpdate($user->id, ['status' => UserStatus::ACTIVE])) {
            return redirect()->route('admin.users.index')->with('success', __('User is unlocked'));
        }

        return redirect()->back()->with('error', __('Failed to unblock user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->userRepo->delete($id);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.users.index')
            ->with('success', __('Deleted Successfully'));
    }
}
