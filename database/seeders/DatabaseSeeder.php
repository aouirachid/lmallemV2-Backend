<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear cached roles/permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Seed permissions and roles first
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        // Create or get initial admin user from env (fallbacks provided)
        $adminName = env('SEED_ADMIN_NAME', 'Aoui Rachid');
        $adminEmail = env('SEED_ADMIN_EMAIL', 'rachid.aoui@lmallem.com');
        $adminUsername = env('SEED_ADMIN_USERNAME', 'rachid.aoui');
        $adminPhone = env('SEED_ADMIN_PHONE', '0000000000');
        $adminCity = env('SEED_ADMIN_CITY', 'Casablanca');
        $adminPassword = env('SEED_ADMIN_PASSWORD', 'aouirachid');

        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName,
                'type' => '1',
                'phone' => $adminPhone,
                'city' => $adminCity,
                'username' => $adminUsername,
                'password' => Hash::make($adminPassword),
            ]
        );

        // Assign Administrator role
        $adminRole = Role::where('name', 'Administrator')->where('guard_name', 'api')->first();
        if ($adminRole) {
            $admin->syncRoles([$adminRole]);
        }
    }
}
