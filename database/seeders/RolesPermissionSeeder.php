<?php

use Illuminate\Database\Seeder;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('permission_role')->insert(array(
            // default users
            array('role_id' => 1, 'permission_id' => 1, 'created_at' => now()),
            
            // clerks
            array('role_id' => 2, 'permission_id' => 2, 'created_at' => now()),
            array('role_id' => 2, 'permission_id' => 3, 'created_at' => now()),
            array('role_id' => 2, 'permission_id' => 6, 'created_at' => now()),

            // managers
            array('role_id' => 3, 'permission_id' => 2, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 3, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 5, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 6, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 7, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 8, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 14, 'created_at' => now()),

            // admin
            array('role_id' => 4, 'permission_id' => 1, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 2, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 3, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 4, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 5, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 6, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 7, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 8, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 9, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 10, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 11, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 12, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 13, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 14, 'created_at' => now()),
        ));
    }
}
