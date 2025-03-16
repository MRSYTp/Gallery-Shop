<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function all()
    {
        $users = User::paginate(10);
        return view('admin.user-all', compact('users'));
    }

    public function add()
    {
        return view('admin.user-add');
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        $createdUser = User::create($validatedData);

        if (!$createdUser) {
            return back()->with('error', 'کاربر با مشکل مواجه شد');
        }

        return back()->with('success', 'کاربر با موفقیت ایجاد شد');
    }

    public function delete($id){
        $user = User::findOrFail($id);

        if (!$user) {
            return back()->with('error', 'کاربر یافت نشد');
        }

        $user->delete();
        return back()->with('success', 'کاربر با موفقیت حذف شد');
    }

    public function edit($id){
        $user = User::findOrFail($id);

        if (!$user) {
            return back()->with('error', 'کاربر یافت نشد');
        }

        return view('admin.user-edit', compact('user'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $validatedData = $request->validated();

        $user = User::findOrFail($id);

        if (!$user) {
            return back()->with('error', 'کاربر یافت نشد');
        }

        $userUpdated = $user->update($validatedData);

        if (!$userUpdated) {
            return back()->with('error', 'کاربر با مشکل مواجه شد');
        }

        return back()->with('success', 'کاربر با موفقیت ویرایش شد');
    }
}
