<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppController extends Controller
{
    /**
     * Handle the start page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function start(Request $request): View
    {
        $max = config('blog.main_page_max_random_count');
        $postsCount = Post::has('content')->visible()->count();
        $posts = Post::with(['author', 'content'])->has('content')->visible()->get()->random($postsCount > $max ? $max : $postsCount);

        $categoriesCount = Category::has('content')->count();
        $categories = Category::with('content')->has('content')->get()->random($categoriesCount > $max ? $max : $categoriesCount);

        return view('app.index')->with([
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    /**
     * Handle the index page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $lang
     * @return \Illuminate\View\View
     */
    public function index(Request $request, string $lang): View
    {
        return $this->start($request);
    }

    /**
     * Handle the about page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $lang
     * @return \Illuminate\View\View
     */
    public function about(Request $request, string $lang): View
    {
        return view('app.about');
    }

    /**
     * Handle the privacy policy page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $lang
     * @return \Illuminate\View\View
     */
    public function privacyPolicy(Request $request, string $lang): View
    {
        return view('app.privacy-policy');
    }
}
