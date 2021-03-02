<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // New Role and Permissions update
        \App\Models\Role::create(array(
            'id' => '10',
            'name'  => 'attendant',
            'label' => 'Attendant',
        ));

        \App\Models\Permission::create(array(
            'id' => '31',
            'name'  => 'check_in',
            'label' => 'Can check people into their appointment'
        ));

        DB::table('permission_role')->insert(array(
            // attendants
            array('role_id' => 10, 'permission_id' => 2, 'created_at' => now()),
            array('role_id' => 10, 'permission_id' => 6, 'created_at' => now()),
            array('role_id' => 10, 'permission_id' => 16, 'created_at' => now()),
            array('role_id' => 10, 'permission_id' => 20, 'created_at' => now()),
            array('role_id' => 10, 'permission_id' => 24, 'created_at' => now()),
            array('role_id' => 10, 'permission_id' => 31, 'created_at' => now()),

            // vaccinators
            array('role_id' => 5, 'permission_id' => 31, 'created_at' => now()),

            // managers
            array('role_id' => 3, 'permission_id' => 31, 'created_at' => now()),
        ));
    }
}
