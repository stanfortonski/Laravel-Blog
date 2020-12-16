<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuthorsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function __invoke($url)
    {
        $user = User::findOrFailByUrl($url);
        return view('app.author')->with('user', $user);
    }
}
