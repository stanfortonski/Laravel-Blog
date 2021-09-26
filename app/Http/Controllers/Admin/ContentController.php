<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Post;
use App\Models\PostContent;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    /**
     * Delete content of category
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategoryContent(Content $content)
    {
        $content->delete();
        return redirect()->back()->withSuccess(__('This language data has been deleted.'));
    }

    /**
     * Delete content of post
     *
     * @param  \App\Models\PostContent  $content
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePostContent(PostContent $postContent)
    {
        $result = DB::select('select post_id from contents_of_posts where content_id = ?', [$postContent->id]);
        if (!empty($result)){
            $result = json_decode(json_encode($result), true);
            $post = Post::find($result[0]['post_id']);

            if (!empty($post)){
                if ($post->author_id != auth()->user()->id && !auth()->user()->hasOneOfRoles(['admin', 'mod'])){
                    abort(403);
                }
            }
        }

        $postContent->delete();
        return redirect()->back()->withSuccess('This language data has been deleted.');
    }
}
