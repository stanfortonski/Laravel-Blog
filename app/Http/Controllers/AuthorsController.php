<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class AuthorsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $lang
     * @param  string  $url
     * @return \Illuminate\View\View
     */
    public function __invoke(string $lang, string $url): View
    {
        $user = User::findOrFailByUrl($url);
        return view('app.'.config('blog.theme').'.author')->with([
            'user' => $user,
            'content' => $user->content()->first()
        ]);
    }
}
