<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuthorsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id)
    {
        $user = User::findOrFail($id);
        return view('app.author')->with('user', $user);
    }
}
