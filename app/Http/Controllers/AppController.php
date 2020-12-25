<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function start(Request $request)
    {
        $max = config('blog.main_page_max_random_count');
        $postsCount = Post::count();
        $posts = Post::with(['author', 'content'])->visible()->get()->random($postsCount > $max ? $max : $postsCount);

        $categoriesCount = Category::count();
        $categories = Category::with('content')->get()->random($categoriesCount > $max ? $max : $categoriesCount);

        return view('app.index')->with([
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $lang
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $lang)
    {
        return $this->start($request);
    }

    public function about(Request $request, $lang)
    {
        return view('app.about');
    }

    public function privacyPolicy(Request $request, $lang)
    {
        return view('app.privacy-policy');
    }
}
