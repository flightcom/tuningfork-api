<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * All the tables that will be cleaned before seeding database
     *
     * @var array
     */
    protected $tables = [
        'users',
        'roles',
        'permissions',
        'permission_role',
        'role_user',
        'posts',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();

        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
    }

    /**
     * Cleans the database of any existing data to ensure no duplicate
     * entries. Should use with caution if ever used in production
     *
     * @return void
     */
    public function cleanDatabase()
    {
        DB::statement('set foreign_key_checks = 0;');

        foreach ($this->tables as $tableName) {
            DB::table($tableName)->truncate();
        }

        DB::statement('set foreign_key_checks = 1;');
    }
}
