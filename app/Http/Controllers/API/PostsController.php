<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        $posts = Post::with(['author', 'categories', 'contents'])->has('contents')->visible()->search($request->q)->orderBy('id', 'desc')->paginate(config('blog.pagination'));
        return PostResource::collection($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \App\Http\Resources\PostResource
     */
    public function show(Post $post): PostResource
    {
        if ($post->isVisible() && !empty($post->contents))
            return new PostResource($post);
        else abort(404);
    }
}
