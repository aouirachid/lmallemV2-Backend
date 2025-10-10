<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Clear cache to avoid issues when reseeding
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = 'api';

        // Create or get roles with guard
        $adminRole = Role::firstOrCreate(['name' => 'Administrator', 'guard_name' => $guard]);
        Role::firstOrCreate(['name' => 'cs - dispatch', 'guard_name' => $guard]);
        Role::firstOrCreate(['name' => 'Onboarding', 'guard_name' => $guard]);
        Role::firstOrCreate(['name' => 'Client', 'guard_name' => $guard]);
        Role::firstOrCreate(['name' => 'Manager', 'guard_name' => $guard]);

        // Grant Administrator all permissions
        $allApiPermissions = Permission::where('guard_name', $guard)->get();
        if ($allApiPermissions->isNotEmpty()) {
            $adminRole->syncPermissions($allApiPermissions);
        }
    }
}
