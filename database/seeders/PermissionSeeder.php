<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Always clear cached permissions/roles before (re)seeding
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = 'api';

        $permissions = [
            'View admin',
            'create admin',
            'update admin',
            'delete admin',
            'create permission',
            'view permission',
            'update permission',
            'delete permission',
            'create role',
            'update role',
            'view role',
            'delete role',
            'Add permission to role',
            'create category',
            'update category',
            'view category',
            'delete category',
            'create service',
            'update service',
            'view service',
            'delete service',
            'create client',
            'view client',
            'update client',
            'delete client',
            'create handy man',
            'view handy man',
            'update handy man',
            'delete handy man',
            'create orders',
            'update orders',
            'view orders',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => $guard,
            ]);
        }
    }
}
