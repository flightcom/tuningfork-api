<?php

use Illuminate\Database\Seeder;
use Models\Role;
use Models\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Creating a default user permission
        $roleDefault = Role::create([
            'slug' => 'default',
            'label' => 'User',
        ]);

        $roleModerator = Role::create([
            'slug' => 'moderator',
            'label' => 'Moderator',
        ]);

        $roleAdmin = Role::create([
            'slug' => 'admin',
            'label' => 'Admin',
        ]);

        $roleSuperAdmin = Role::create([
            'slug' => 'super_admin',
            'label' => 'Super Admin',
        ]);

        $users = User::where('email', '!=', config('constants.root_user'))->get();

        foreach ($users as $user) {
            $user->assignRole($roleDefault);
        }

        $root_user = User::where('email', config('constants.root_user'))->first();
        $root_user->assignRole($roleSuperAdmin);

        $admin_user = User::where('email', config('constants.admin_user'))->first();
        $admin_user->assignRole($roleAdmin);

        $moderator_user = User::where('email', config('constants.moderator_user'))->first();
        $moderator_user->assignRole($roleModerator);
    }
}
