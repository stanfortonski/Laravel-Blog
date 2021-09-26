<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        $categories = Category::with(['contents'])->has('contents')->search($request->q)->paginate(config('blog.pagination'));
        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \App\Http\Resources\CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        if (!empty($category->contents))
            return new CategoryResource($category);
        else abort(404);
    }
}
