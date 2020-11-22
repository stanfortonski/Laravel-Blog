<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    private $roles = [
        ['name' => 'admin', 'description' => 'Admin'],
        ['name' => 'mod', 'description' => 'Moderator'],
        ['name' => 'writer', 'description' => 'Writer']
    ];

    public function run()
    {
        foreach ($this->roles as $role){
            DB::table('roles')->insert($role);
        }
    }
}
