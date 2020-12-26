<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\AuthorContent;
use App\Models\User;
use App\Services\ImageSaver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Stanfortonski\Laravelroles\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('roles')->search($request->q)->paginate(config('blog.pagination'));
        return view('admin.users.index')->with([
            'users' => $users,
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
        return view('admin.users.save');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $this->validate($request, ['email' => Rule::unique('users')]);

        DB::beginTransaction();
        try {
            $data = $this->getValidatedData($request);
            if ($request->hasFile('thumbnail'))
                $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();

            $user = User::create($data);
            $this->saveRoles($request, $user);
            $content = new AuthorContent;
            $content->content = $request->content;
            $content->lang = app()->getLocale();
            $user->contents()->saveMany([$content]);
            DB::commit();

            return redirect()->route('admin.categories.edit', $user->id)->withSuccess('admin.users.store');
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.save')->with([
            'user' =>  $user,
            'content' => $user->content()->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\UserStoreRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserStoreRequest $request, User $user)
    {
        $this->validate($request, ['email' => Rule::unique('users')->ignore($user->id)]);

        DB::beginTransaction();
        try {
            $data = $this->getValidatedData($request);
            if ($request->hasFile('thumbnail')){
                if (!empty($user->thumbnail_path))
                    Storage::delete('/public/thumbnails/'.$user->thumbnail_path);
                $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();
            }

            $user->update($data);
            $this->saveRoles($request, $user);
            $content = $user->content()->first();
            if (empty($content)){
                $content = new AuthorContent;
                $content->content = $request->content;
                $content->lang = app()->getLocale();
                $user->contents()->saveMany([$content]);
            }
            else $content->update(['content' => $request->content]);
            DB::commit();

            return redirect()->back()->withSuccess('admin.users.update');
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->withSuccess('admin.users.destroy');
    }

    /**
     * Get Validated Data.
     *
     * @param  \App\Requests\UserStoreRequest  $request
     * @return array
     */
    private function getValidatedData(UserStoreRequest $request): array
    {
        $data = $request->validated();
        if (!empty($data['password']))
            $data['password'] = Hash::make($data['password']);
        unset($data['content'], $data['thumbnail'], $data['roles']);
        return $data;
    }

    /**
     * Store User Roles.
     *
     * @param  \App\Requests\UserStoreRequest  $request
     * @param  \App\Models\User  $user
     * @return void
     */
    private function saveRoles(UserStoreRequest $request, User $user)
    {
        DB::table('users_roles')->where('user_id', '=', $user->id)->delete();
        if (!empty($request->roles)){
            $roles = [];
            foreach ($request->roles as $id){
                $role = Role::find($id);
                if (!empty($role))
                    $roles[] = $role;
            }
            $user->roles()->saveMany($roles);
        }
    }
}
