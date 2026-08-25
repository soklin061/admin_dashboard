<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Remove old space-based permissions
        Permission::where('name', 'LIKE', '% %')->delete();

        // Create CRUD permissions
        $permissions = [
            // User permissions
            'view-users',
            'show-users',
            'create-users',
            'edit-users',
            'update-users',
            'delete-users',
            'manage-users',

            // Role permissions
            'view-roles',
            'show-roles',
            'create-roles',
            'edit-roles',
            'update-roles',
            'delete-roles',
            'manage-roles',

            // Permission permissions
            'view-permissions',
            'show-permissions',
            'create-permissions',
            'edit-permissions',
            'update-permissions',
            'delete-permissions',
            'manage-permissions',

            // Setting permissions
            'view-settings',
            'show-settings',
            'edit-settings',
            'update-settings',
            'manage-settings',

            // Log permissions
            'view-logs',
            'show-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // Create roles and assign permissions
        $adminRole = Role::findOrCreate('Admin', 'web');
        $adminRole->syncPermissions(Permission::all());

        $managerRole = Role::findOrCreate('Manager', 'web');
        $managerRole->syncPermissions([
            'view-users',
            'show-users',
            'create-users',
            'edit-users',
            'update-users',
            'view-logs',
            'show-logs',
        ]);

        $userRole = Role::findOrCreate('User', 'web');
        $userRole->syncPermissions([
            'view-users',
            'show-users',
        ]);
    }
}
