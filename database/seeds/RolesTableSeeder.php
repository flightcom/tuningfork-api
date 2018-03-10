<?php

use Illuminate\Database\Seeder;

use Models\Role;
use Models\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating a default user permission
        $role = Role::create([
            'slug' => 'default_user',
            'label' => 'User'
        ]);

        $users = User::where('email', '!=', config('constants.root_user'))->get();

        foreach($users as $user) {
            $user->assignRole('default_user');
        }
    }
}
