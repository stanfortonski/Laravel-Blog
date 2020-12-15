<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    private $roles = [
        ['name' => 'admin', 'description' => 'Admin'],
        ['name' => 'mod', 'description' => 'Moderator']
    ];

    public function run()
    {
        foreach ($this->roles as $role){
            DB::table('roles')->insert($role);
        }
    }
}
