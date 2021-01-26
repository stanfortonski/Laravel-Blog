<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordRequest;
use App\Models\AuthorContent;
use App\Rules\Name;
use App\Http\Requests\ImageRequest;
use App\Rules\RealName;
use App\Services\ThumbnailManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserPanelController extends Controller
{
    use ThumbnailManager;

    public function index()
    {
        return view('admin.user-panel.index')->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', new Name, Rule::unique('users', 'name')->ignore($user->id)],
            'first_name' => ['required', 'string', 'max:255', new RealName],
            'last_name' => ['required', 'string', 'max:255', new RealName],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'content' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
        ], [], [
            'first_name' => __('First Name'),
            'last_name' => __('Last Name'),
            'name' => __('Name'),
            'email' => __('E-Mail Address'),
            'content' => __('content'),
            'website' => __('website')
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'email' => $request->email,
                'name' => $request->name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'website' => $request->website
            ]);

            $content = $user->content()->first();
            if (empty($content)){
                $content = new AuthorContent();
                $content->content = $request->content;
                $content->lang = app()->getLocale();
                $user->contents()->saveMany([$content]);
            }
            else $content->update(['content' => $request->content]);
            DB::commit();

            return redirect()->back()->withSuccess('admin.userpanel.update');
        }
        catch (Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->withSuccess('admin.error');
        }
    }

    /**
     * Update the password resource in storage.
     *
     * @param  \App\Http\Requests\UserPasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UserPasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->update();

        return redirect()->back()->withSuccess('admin.userpanel.password');
    }

    /**
     * Changes the thumbnail in storage.
     *
     * @param  \App\Http\Requests\ImageRequest   $request
     * @return \Illuminate\Http\Response
     */
    public function updateImage(ImageRequest $request)
    {
        $user = auth()->user();
        $this->deleteThumbnail($user);
        $user->thumbnail_path = $this->storeThumbnail($request);
        $user->update();

        return redirect()->back()->withSuccess('admin.thumbnail.update');
    }

    /**
     * Remove the thumbnail from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyImage()
    {
        $user = auth()->user();
        $this->deleteThumbnail($user);
        $user->thumbnail_path = null;
        $user->update();

        return redirect()->back()->withSuccess('admin.thumbnail.destroy');
    }
}
