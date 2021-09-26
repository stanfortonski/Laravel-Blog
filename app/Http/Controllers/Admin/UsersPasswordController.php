<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersPasswordController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\UserPasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(UserPasswordRequest $request, User $user)
    {
        $user->password = Hash::make($request->password);
        $user->update();
        return redirect()->back()->withSuccess('admin.users.password');
    }
}
