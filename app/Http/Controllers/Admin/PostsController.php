<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Models\Category;
use App\Models\Content;
use App\Models\Post;
use App\Services\ImageSaver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::with(['author', 'categories', 'content'])->orderBy('id', 'desc')->search($request->q)->paginate(config('blog.pagination'));
        return view('admin.posts.index')->with([
            'posts' => $posts,
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
        return view('admin.posts.save');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\PostStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->getValidatedData($request);
            if ($request->hasFile('thumbnail'))
                $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();

            $contentData = $request->content;
            $contentData['lang'] = app()->getLocale();

            $post = Post::create($data);
            $this->saveCategories($request, $post);
            $content = Content::create($contentData);
            $post->contents()->saveMany([$content]);
            DB::commit();

            return redirect()->route('admin.posts.edit', $post->id)->withSuccess('admin.posts.store');
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
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if ($post->user_id == auth()->user()->id || auth()->user()->hasOneOfRoles(['admin', 'mod'])){
            return view('admin.posts.save')->with([
                'post' => $post,
                'content' => $post->content()->first()
            ]);
        }
        else abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\PostStoreRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostStoreRequest $request, Post $post)
    {
        if ($post->user_id == auth()->user()->id || auth()->user()->hasOneOfRoles(['admin', 'mod'])){
            DB::beginTransaction();
            try {
                $data = $this->getValidatedData($request);
                if ($request->hasFile('thumbnail')){
                    if (!empty($post->thumbnail_path))
                        Storage::delete('/public/thumbnails/'.$post->thumbnail_path);
                    $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();
                }

                $contentData = $request->content;
                $contentData['lang'] = app()->getLocale();

                $post->update($data);
                $this->saveCategories($request, $post);

                $content = $post->content()->first();
                if (empty($content)){
                    $content = Content::create($contentData);
                    $post->contents()->saveMany([$content]);
                }
                else $content->update($contentData);
                DB::commit();

                return redirect()->back()->withSuccess('admin.posts.update');
            }
            catch (Exception $e){
                DB::rollBack();
                Log::error($e->getMessage());
                return redirect()->back()->withError('admin.error');
            }
        }
        else abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->user_id == auth()->user()->id || auth()->user()->hasOneOfRoles(['admin', 'mod'])){
            $post->delete();
            return redirect()->route('admin.posts.index')->withSuccess('admin.posts.destroy');
        }
        else abort(403);
    }

    /**
     * Get Validated Data.
     *
     * @param  \App\Requests\PostStoreRequest  $request
     * @return array
     */
    private function getValidatedData(PostStoreRequest $request): array
    {
        $data = $request->validated();
        $data['author_id'] = auth()->user()->id;
        $data['is_visible'] = $request->has('is_visible');
        if (!empty($data['publish_at_date'])){
            $data['publish_at'] = "{$data['publish_at_date']} {$data['publish_at_time']}";
            unset($data['publish_at_date']);
            unset($data['publish_at_time']);
        }
        unset($data['content'], $data['thumbnail'], $data['categories']);
        return $data;
    }

    /**
     * Store Post Categories.
     *
     * @param  \App\Requests\UserStoreRequest  $request
     * @param  \App\Models\Post  $post
     * @return void
     */
    private function saveCategories(PostStoreRequest $request, Post $post)
    {
        DB::table('posts_of_categories')->where('post_id', '=', $post->id)->delete();
        if (!empty($request->categories)){
            $categories = [];
            foreach ($request->categories as $id){
                $category = Category::find($id);
                if (!empty($category))
                    $categories[] = $category;
            }
            $post->categories()->saveMany($categories);
        }
    }
}
