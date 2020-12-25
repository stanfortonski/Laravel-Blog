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
            'first_name' => 'Stan',
            'last_name' => 'Fortoński',
            'email' => 'admin@laravel-blog.test',
            'website' => 'https://stanfortonski.dev',
            'password' => Hash::make('rootroot'),
            'email_verified_at' => now(),
            'remember_token' => ''
        ]);

        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
    }
}
