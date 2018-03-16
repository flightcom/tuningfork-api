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

        // USER permissions
        $permissions[] = Permission::create([
            'slug' => 'user_index',
            'label' => 'User Query',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'user_self',
            'label' => 'User Self',
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

        // INSTRUMENT permissions
        $permissions[] = Permission::create([
            'slug' => 'instrument_index',
            'label' => 'Instrument Query',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'instrument_store',
            'label' => 'Instrument Create',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'instrument_show',
            'label' => 'Instrument Read',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'instrument_update',
            'label' => 'Instrument Update',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'instrument_destroy',
            'label' => 'Instrument Delete',
        ]);

        // MEMBERSHIP permissions
        $permissions[] = Permission::create([
            'slug' => 'membership_index',
            'label' => 'Membership Query',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'membership_store',
            'label' => 'Membership Create',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'membership_show',
            'label' => 'Membership Read',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'membership_update',
            'label' => 'Membership Update',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'membership_destroy',
            'label' => 'Membership Delete',
        ]);

        // STATION permissions
        $permissions[] = Permission::create([
            'slug' => 'station_index',
            'label' => 'Station Query',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'station_store',
            'label' => 'Station Create',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'station_show',
            'label' => 'Station Read',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'station_update',
            'label' => 'Station Update',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'station_destroy',
            'label' => 'Station Delete',
        ]);

        // BRAND permissions
        $permissions[] = Permission::create([
            'slug' => 'brand_index',
            'label' => 'Brand Query',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'brand_store',
            'label' => 'Brand Create',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'brand_show',
            'label' => 'Brand Read',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'brand_update',
            'label' => 'Brand Update',
        ]);

        $permissions[] = Permission::create([
            'slug' => 'brand_destroy',
            'label' => 'Brand Delete',
        ]);

        // Admin role
        $roleAdmin = Role::where('slug', 'admin')->first();
        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            $roleAdmin->givePermissionTo($permission);
        }

        // Default user role
        $roleDefaultUser = Role::where('slug', 'default')->first();
        $roleDefaultUser->givePermissionTo(Permission::where('slug', 'user_store')->first());
        $roleDefaultUser->givePermissionTo(Permission::where('slug', 'user_self')->first());
        $roleDefaultUser->givePermissionTo(Permission::where('slug', 'instrument_index')->first());
        $roleDefaultUser->givePermissionTo(Permission::where('slug', 'instrument_show')->first());
    }
}
