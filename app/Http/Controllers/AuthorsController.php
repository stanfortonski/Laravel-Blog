<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuthorsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $lang
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function __invoke($lang, $url)
    {
        $user = User::findOrFailByUrl($url);
        return view('app.'.config('blog.theme').'.author')->with([
            'user' => $user,
            'content' => $user->content()->first()
        ]);
    }
}
