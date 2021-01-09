<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CRUD permissions
        \App\Models\Permission::create(array(
            'id' => '1',
            'name'  => 'create_registration',
            'label' => 'Can register'
        ));
        \App\Models\Permission::create(array(
            'id' => '2',
            'name'  => 'read_registration',
            'label' => 'Can view registrations'
        ));
        \App\Models\Permission::create(array(
            'id' => '3',
            'name'  => 'update_registration',
            'label' => 'Can update live registrations'
        ));
        \App\Models\Permission::create(array(
            'id' => '4',
            'name'  => 'delete_registration',
            'label' => 'Can delete registrations'
        ));
        \App\Models\Permission::create(array(
            'id' => '5',
            'name'  => 'create_location',
            'label' => 'Can add new locations/sites for appointments'
        ));
        \App\Models\Permission::create(array(
            'id' => '6',
            'name'  => 'read_location',
            'label' => 'Can view locations and details'
        ));
        \App\Models\Permission::create(array(
            'id' => '7',
            'name'  => 'update_location',
            'label' => 'Can update location information'
        ));
        \App\Models\Permission::create(array(
            'id' => '8',
            'name'  => 'delete_location',
            'label' => 'Can remove a location'
        ));
        \App\Models\Permission::create(array(
            'id' => '9',
            'name'  => 'create_user',
            'label' => 'Can create a new user'
        ));
        \App\Models\Permission::create(array(
            'id' => '10',
            'name'  => 'read_user',
            'label' => 'Can view all users'
        ));
        \App\Models\Permission::create(array(
            'id' => '11',
            'name'  => 'update_user',
            'label' => 'Can update a user\'s information'
        ));
        \App\Models\Permission::create(array(
            'id' => '12',
            'name'  => 'delete_user',
            'label' => 'Can remove a user'
        ));

        // Special Permissions
        \App\Models\Permission::create(array(
            'id' => '13',
            'name'  => 'assign_roles',
            'label' => 'Can assign a role to a user'
        ));
        \App\Models\Permission::create(array(
            'id' => '14',
            'name'  => 'keep_inventory',
            'label' => 'Can modify inventory for external conditions'
        ));
    }
}
