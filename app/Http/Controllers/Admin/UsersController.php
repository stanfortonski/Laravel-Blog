<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSaveRequest;
use App\Models\User;
use App\Services\ImageSaver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $users = User::search($request->q)->paginate(config('blog.pagination'));
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
     * @param  \App\Requests\UserSaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserSaveRequest $request)
    {
        $this->validate($request, ['email' => Rule::unique('users')]);

        DB::beginTransaction();
        try {
            $data = $request->validated();
            if ($request->hasFile('thumbnail'))
                $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();
            unset($data['thumbnail']);

            User::create($data);
            return redirect()->back()->withSuccess('admin.users.store');
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
        return view('admin.users.save')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\UserSaveRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserSaveRequest $request, User $user)
    {
        $this->validate($request, ['email' => Rule::unique('users')->ignore($user->id)]);

        DB::beginTransaction();
        try {
            $data = $request->validated();
            if ($request->hasFile('thumbnail')){
                if (!empty($user->thumbnail_path))
                    Storage::delete('/public/thumbnails/'.$user->thumbnail_path);
                $data['thumbnail_path'] = (new ImageSaver($request))->getFileName();
            }
            unset($data['thumbnail']);

            $user->update($data);
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
        return redirect()->back()->withSuccess('admin.users.destroy');
    }
}
