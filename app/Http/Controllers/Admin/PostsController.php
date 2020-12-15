<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostSaveRequest;
use App\Models\Post;
use App\Services\ImageSaver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $posts = Post::with(['author', 'categories'])->orderBy('id', 'desc')->search($request->q)->paginate(config('blog.pagination'));
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
     * @param  \App\Requests\PostSaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostSaveRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->getValidatedData($request);
            if ($request->hasFile('thumbnail'))
                $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();
            unset($data['thumbnail']);

            Post::create($data);
            return redirect()->back()->withSuccess('admin.posts.store');
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
        if ($post->user_id == auth()->user()->id || auth()->user()->hasOneOfRoles(['admin', 'mod']))
            return view('admin.posts.save')->with('post', $post);
        else abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\PostSaveRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostSaveRequest $request, Post $post)
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
                unset($data['thumbnail']);

                $post->update($data);
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
            return redirect()->back()->withSuccess('admin.posts.destroy');
        }
        else abort(403);
    }

    /**
     * Get Validated Data
     *
     * @param  \App\Requests\PostSaveRequest  $request
     * @return array
     */
    private function getValidatedData(PostSaveRequest $request): array
    {
        $data = $request->validated();
        if (!empty($data['publish_at_date'])){
            $data['publish_at']  = "{$data['publish_at_date']} {$data['publish_at_time']}";
            unset($data['publish_at_date']);
            unset($data['publish_at_time']);
        }
        unset($data['thumbnail']);
        return $data;
    }
}
