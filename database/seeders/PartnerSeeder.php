<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
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
            'id' => '8',
            'name'  => 'partner',
            'label' => 'Partner',
        ));

        \App\Models\Role::create(array(
            'id' => '9',
            'name'  => 'red_leader',
            'label' => 'Red Leader',
        ));

        \App\Models\Permission::create(array(
            'id' => '27',
            'name'  => 'read_partner_event',
            'label' => 'Can view partner event details tag'
        ));
        \App\Models\Permission::create(array(
            'id' => '28',
            'name'  => 'manage_partner_event',
            'label' => 'Can manage contacts in a partner event'
        ));
        \App\Models\Permission::create(array(
            'id' => '29',
            'name'  => 'manage_tag',
            'label' => 'Can manage tags within the application'
        ));
        \App\Models\Permission::create(array(
            'id' => '30',
            'name'  => 'skeleton_key',
            'label' => 'Can open every door'
        ));

        DB::table('permission_role')->insert(array(
            // partners
            array('role_id' => 8, 'permission_id' => 27, 'created_at' => now()),
            array('role_id' => 8, 'permission_id' => 28, 'created_at' => now()),

            // the masters
            array('role_id' => 9, 'permission_id' => 30, 'created_at' => now()),
        ));
    }
}
