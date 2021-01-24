<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\Content;
use App\Services\ImageSaver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $categories = Category::with('content')->search($request->q)->paginate(config('blog.pagination'));
        return view('admin.categories.index')->with([
            'categories' => $categories,
            'q' => $request->q,
            'searchData' => $request->only('q')
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
     * @param  \App\Requests\CategoryStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->getValidatedData($request);
            if ($request->hasFile('thumbnail'))
                $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();

            $contentData = $request->content;
            $contentData['lang'] = app()->getLocale();

            $category = Category::create($data);
            $content = Content::create($contentData);
            $category->contents()->saveMany([$content]);
            DB::commit();

            return redirect()->route('admin.categories.edit', $category->id)->withSuccess('admin.categories.store');
        }
        catch (Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->withError('admin.error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.save')->with([
            'category' => $category,
            'content' => $category->content()->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\CategoryStoreRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryStoreRequest $request, Category $category)
    {
        DB::beginTransaction();
        try {
            $data = $this->getValidatedData($request);
            if ($request->hasFile('thumbnail')){
                if (!empty($category->thumbnail_path))
                    Storage::delete('/public/thumbnails/'.$category->thumbnail_path);
                $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();
            }

            $contentData = $request->content;
            $contentData['lang'] = app()->getLocale();

            $category->update($data);
            $content = $category->content()->first();
            if (empty($content)){
                $content = Content::create($contentData);
                $category->contents()->saveMany([$content]);
            }
            else $content->update($contentData);
            DB::commit();

            return redirect()->back()->withSuccess('admin.categories.update');
        }
        catch (Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->withError('admin.error');
        }
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
        return redirect()->route('admin.categories.index')->withSuccess('admin.categories.destroy');
    }

    /**
     * Get Validated Data.
     *
     * @param  \App\Requests\CategoryStoreRequest  $request
     * @return array
     */
    private function getValidatedData(CategoryStoreRequest $request): array
    {
        $data = $request->validated();
        unset($data['content'], $data['thumbnail']);
        return $data;
    }
}
