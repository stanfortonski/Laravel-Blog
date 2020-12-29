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
        $posts = Post::with(['author', 'content'])->has('content')->visible()->search($request->q)->orderBy('id', 'desc')->paginate(config('blog.pagination'));
        return view('app.posts.index')->with([
            'q' => $request->q ?? '',
            'posts' => $posts
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
        if ($post->isVisible())
            return view('app.posts.show')->with([
                'post' => $post,
                'content' => $post->content()->firstOrFail()
            ]);
        else abort(404);
    }
}
