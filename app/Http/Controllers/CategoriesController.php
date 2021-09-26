<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $lang
     * @return \Illuminate\View\View
     */
    public function index(Request $request, string $lang): View
    {
        $categories = Category::with('content')->has('content')->search($request->q)->paginate(config('blog.pagination'))->withQueryString();
        return view('app.'.config('blog.theme').'.categories.index')->with([
            'categories' => $categories,
            'q' => $request->q
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $lang
     * @param  string  $url
     * @return \Illuminate\View\View
     */
    public function show(string $lang, string $url): View
    {
        $category = Category::findOrFailByUrl($url);

        return view('app.'.config('blog.theme').'.categories.show')->with([
            'category' => $category,
            'content' => $category->content()->first(),
            'posts' => $category->posts()->has('content')->visible()->paginate(config('blog.pagination'))
        ]);
    }
}
