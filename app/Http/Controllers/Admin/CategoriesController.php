<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\SetLangInAdminPanel;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\ImageRequest;
use App\Models\Category;
use App\Models\Content;
use App\Services\CategoryContentUrlValidator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    use CategoryContentUrlValidator;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $categories = Category::with('content')->search($request->q)->paginate(config('blog.pagination'))->withQueryString();
        return view('admin.categories.index')->with([
            'categories' => $categories,
            'q' => $request->q
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.categories.save');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\CategoryStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryStoreRequest $request)
    {
        SetLangInAdminPanel::setLang($request->content['lang']);

        if (!$this->validateContentUrl($request))
            return redirect()->back()->withError(__('This url already exists.'));

        DB::beginTransaction();
        try {
            $data = $this->getValidatedData($request);
            $category = Category::create($data);

            $content = Content::create($request->content);
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
     * @return \Illuminate\View\View
     */
    public function edit(Category $category): View
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryStoreRequest $request, Category $category)
    {
        SetLangInAdminPanel::setLang($request->content['lang']);

        $content = $category->content()->first();
        if (!empty($content)){
            if (!$this->validateContentUrlWithoutOne($request, $content))
                return redirect()->back()->withError(__('This url already exists.'));
        }
        else {
            if (!$this->validateContentUrl($request))
                return redirect()->back()->withError(__('This url already exists.'));
        }

        DB::beginTransaction();
        try {
            $data = $this->getValidatedData($request);
            $category->update($data);

            $contentData = $request->content;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->withSuccess('admin.categories.destroy');
    }

    /**
     * Changes the thumbnail in storage.
     *
     * @param  \App\Http\Requests\ImageRequest   $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateImage(ImageRequest $request, Category $category)
    {
        $category->thumbnail_path = $request->thumbnail_path;
        $category->update();

        return redirect()->back()->withSuccess('admin.thumbnail.update');
    }

    /**
     * Remove the thumbnail from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyImage(Category $category)
    {
        $category->thumbnail_path = null;
        $category->update();

        return redirect()->back()->withSuccess('admin.thumbnail.destroy');
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
