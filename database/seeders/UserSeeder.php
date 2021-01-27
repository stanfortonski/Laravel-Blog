<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'root',
            'first_name' => 'Super',
            'last_name' => 'User',
            'email' => 'admin@laravel-blog.test',
            'website' => 'https://stanfortonski.dev',
            'password' => Hash::make('rootroot'),
            'url' => 'super-user',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => ''
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
    }
}
