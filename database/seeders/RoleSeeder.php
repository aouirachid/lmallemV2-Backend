<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create default roles
        Role::create(['name' => 'Administrator']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Manager']);
    }
}
