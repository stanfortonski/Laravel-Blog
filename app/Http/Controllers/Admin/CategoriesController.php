<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategorySaveRequest;
use App\Models\Category;
use App\Services\ImageSaver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('title', 'asc')->search($request->q)->paginate(config('blog.pagination'));
        return view('admin.categories.index')->with([
            'categories' => $categories,
            'q' => $request->q ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.save');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\CategorySaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorySaveRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail'))
            $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();
        unset($data['thumbnail']);

        Category::create($data);
        return redirect()->back()->withSuccess('admin.categories.store');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.save')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\CategorySaveRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategorySaveRequest $request, Category $category)
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')){
            if (!empty($category->thumbnail_path))
                Storage::delete('/public/thumbnails/'.$category->thumbnail_path);
            $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();
        }
        unset($data['thumbnail']);

        $category->update($data);
        return redirect()->back()->withSuccess('admin.categories.update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->withSuccess('admin.categories.destroy');
    }
}
