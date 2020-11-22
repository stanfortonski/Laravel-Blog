<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('title', 'asc')->search($request->q)->paginate(config('blog.pagination'));
        return view('app.categories.index')->with('categories', $categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('app.categories.show')->with([
            'category' => $category,
            'posts' => $category->posts()->visible()->paginate(config('blog.pagination'))
        ]);
    }
}
