<?php

use Illuminate\Database\Seeder;
use Models\Permission;
use Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [];

        $permissions[] = Permission::create([
            'slug' => 'backend_access',
            'label' => 'Backend Access',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'permission_index',
            'label' => 'Permission Query',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'permission_store',
            'label' => 'Permission Create',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'permission_update',
            'label' => 'Permission Update',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'permission_destroy',
            'label' => 'Permission Delete',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'role_index',
            'label' => 'Role Query',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'role_store',
            'label' => 'Role Create',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'role_update',
            'label' => 'Role Update',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'role_destroy',
            'label' => 'Role Delete',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'sync_roles',
            'label' => 'Sync Roles',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'sync_permissions',
            'label' => 'Sync Permissions',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'user_index',
            'label' => 'User Query',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'user_store',
            'label' => 'User Create',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'user_show',
            'label' => 'User Read',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'user_update',
            'label' => 'User Update',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'user_destroy',
            'label' => 'User Delete',
        ]);

        $roleDefaultUser = Role::where('slug', 'default_user')->first();
        $roleDefaultUser->givePermissionTo(Permission::where('slug', 'user_store')->first());
    }
}
