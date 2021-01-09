<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create(array(
            'id' => '1',
            'name'  => 'user',
            'label' => 'Default User',
        ));
        \App\Models\Role::create(array(
            'id' => '2',
            'name'  => 'clerk',
            'label' => 'Clerk',
        ));
        \App\Models\Role::create(array(
            'id' => '3',
            'name'  => 'manager',
            'label' => 'Manager',
        ));
        \App\Models\Role::create(array(
            'id' => '4',
            'name'  => 'admin',
            'label' => 'Administrator',
        ));
    }
}
