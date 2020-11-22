<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::with('author')->visible()->search($request->q)->orderBy('created_at', 'desc')->paginate(config('blog.pagination'));
        return view('app.posts.index')->with([
            'q' => $request->q ?? '',
            'posts' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if ($post->isVisible())
            return view('app.posts.show')->with('post', $post);
        else abort(404);
    }
}
