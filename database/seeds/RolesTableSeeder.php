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
        $role = Role::create([
            'slug' => 'default_user',
            'label' => 'User',
        ]);

        $role = Role::create([
            'slug' => 'admin',
            'label' => 'Admin',
        ]);

        $role = Role::create([
            'slug' => 'super_admin',
            'label' => 'Super Admin',
        ]);

        $users = User::where('email', '!=', config('constants.root_user'))->get();

        foreach ($users as $user) {
            $user->assignRole('default_user');
        }

        $root_user = User::where('email', config('constants.root_user'))->first();
        $root_user->assignRole('super_admin');
    }
}
