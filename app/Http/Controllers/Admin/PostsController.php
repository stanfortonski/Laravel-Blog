<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\SetLangInAdminPanel;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\PostStoreRequest;
use App\Models\Category;
use App\Models\PostContent;
use App\Models\Post;
use App\Services\PostContentUrlValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class PostsController extends Controller
{
    use PostContentUrlValidator;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::with(['author', 'categories', 'content'])->orderBy('id', 'desc')->search($request->q)->paginate(config('blog.pagination'))->withQueryString();
        return view('admin.posts.index')->with([
            'posts' => $posts,
            'q' => $request->q
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
        SetLangInAdminPanel::setLang($request->content['lang']);

        if (!$this->validateContentUrl($request))
            return redirect()->back()->withError(__('This url already exists.'));

        DB::beginTransaction();
        try {
            $data = $this->getValidatedData($request);
            $post = Post::create($data);

            $this->saveCategories($request, $post);

            $content = PostContent::create($request->content);
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
        SetLangInAdminPanel::setLang($request->content['lang']);

        $content = $post->content()->first();
        if (!empty($content)){
            if (!$this->validateContentUrlWithoutOne($request, $content))
                return redirect()->back()->withError(__('This url already exists.'));
        }
        else {
            if (!$this->validateContentUrl($request))
                return redirect()->back()->withError(__('This url already exists.'));
        }

        if ($post->user_id == auth()->user()->id || auth()->user()->hasOneOfRoles(['admin', 'mod'])){
            DB::beginTransaction();
            try {
                $data = $this->getValidatedData($request);
                unset($data['author_id']);
                $post->update($data);
                $this->saveCategories($request, $post);

                $contentData = $request->content;
                if (empty($content)){
                    $content = PostContent::create($contentData);
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
     * Changes the thumbnail in storage.
     *
     * @param  \App\Http\Requests\ImageRequest   $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function updateImage(ImageRequest $request, Post $post)
    {
        if ($post->user_id == auth()->user()->id || auth()->user()->hasOneOfRoles(['admin', 'mod'])){
            $post->thumbnail_path = $request->thumbnail_path;
            $post->update();

            return redirect()->back()->withSuccess('admin.thumbnail.update');
        }
        else abort(403);
    }

    /**
     * Remove the thumbnail from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroyImage(Post $post)
    {
        if ($post->user_id == auth()->user()->id || auth()->user()->hasOneOfRoles(['admin', 'mod'])){
            $post->thumbnail_path = null;
            $post->update();

            return redirect()->back()->withSuccess('admin.thumbnail.destroy');
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
        unset($data['content'], $data['categories']);
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
