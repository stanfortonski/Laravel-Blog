<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $max = config('blog.main_page_max_random_count');
        $postsCount = Post::count();
        $posts = Post::with('author')->visible()->get()->random($postsCount > $max ? $max : $postsCount);

        $categoriesCount = Category::count();
        $categories = Category::all()->random($categoriesCount > $max ? $max : $categoriesCount);

        return view('app.index')->with([
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    public function about(Request $request)
    {
        return view('app.about');
    }

    public function privacyPolicy(Request $request)
    {
        return view('app.privacy-policy');
    }
}
