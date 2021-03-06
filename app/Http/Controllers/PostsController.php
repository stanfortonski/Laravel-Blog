<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $lang
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $lang)
    {
        $posts = Post::with(['author', 'content'])->has('content')->visible()->search($request->q)->orderBy('id', 'desc')->paginate(config('blog.pagination'))->withQueryString();
        return view('app.'.config('blog.theme').'.posts.index')->with([
            'posts' => $posts,
            'q' => $request->q
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $lang
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $url)
    {
        $post = Post::findOrFailByUrl($url);
        if ($post->isVisible() || (auth()->check() && (auth()->user()->id == $post->user_id || auth()->user()->hasRole('admin')))){
            return view('app.'.config('blog.theme').'.posts.show')->with([
                'post' => $post,
                'content' => $post->content()->firstOrFail()
            ]);
        }
        else abort(404);
    }
}
