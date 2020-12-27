<?php

namespace Tests;

use App\Models\User;

trait TestUtils
{
    public function getRandomUser(){
        return User::all()->random();
    }

    public function getAdmin(){
        return $this->getUserPrivileged('admin');
    }

    public function getUserPrivileged($roleName){
        return User::whereHas('roles', function($query) use($roleName){
            $query->where('name', '=', $roleName);
        })->get()->random();
    }

    public function getUserNotPrivileged($roleName){
        return User::whereDoesntHave('roles', function($query) use($roleName){
            $query->where('name', '=', $roleName);
        })->get()->random();
    }
}
