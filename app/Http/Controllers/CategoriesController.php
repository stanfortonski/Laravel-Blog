<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
        $categories = Category::with('content')->has('content')->search($request->q)->paginate(config('blog.pagination'));
        return view('app.categories.index')->with([
            'categories' => $categories,
            'q' => $request->q,
            'searchData' => $request->only('q')
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
        $category = Category::findOrFailByUrl($url);

        return view('app.categories.show')->with([
            'category' => $category,
            'content' => $category->content()->first(),
            'posts' => $category->posts()->has('content')->visible()->paginate(config('blog.pagination'))
        ]);
    }
}
