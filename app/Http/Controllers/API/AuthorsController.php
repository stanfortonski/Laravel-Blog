<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class AuthorsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \App\Http\Resources\UserResource
     */
    public function __invoke(User $user): UserResource
    {
        return new UserResource($user);
    }
}
