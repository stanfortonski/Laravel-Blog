<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;

class PostsPublishment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Post::whereNotNull('publish_at')->where('publish_at', '>=', now())->update([
            'publish_at' => null,
            'is_visible' => true
        ]);
        return $next($request);
    }
}
