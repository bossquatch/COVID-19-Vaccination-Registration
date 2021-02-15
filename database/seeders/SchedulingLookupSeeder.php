<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchedulingLookupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // InviteStatus Seed
        \App\Models\InviteStatus::insert([
            ['id' => 1, 'name' => 'Assigned', 'description' => 'Registration has been assigned, awaiting system to contact.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Awaiting Callback', 'description' => 'Someone needs to manually reach out to confirm/deny appointment.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Awaiting Response', 'description' => 'User has been contacted, waiting for confirmation.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Expired', 'description' => 'No response from user within allotted time.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Declined', 'description' => 'User declined invitation.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Accepted', 'description' => 'User accepted, awaiting appointment date.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Checked In', 'description' => 'User arrived to appointment.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'No Show', 'description' => 'User did not show up to accepted appointment.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Turned Down', 'description' => 'User was turned down the shot for some reason.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Received Vaccine', 'description' => 'User was vaccinated.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ContactMethod Seed
        \App\Models\ContactMethod::insert([
            ['id' => 1, 'label' => 'Called', 'is_system' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'label' => 'Emailed', 'is_system' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'label' => 'IVR', 'is_system' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'label' => 'Emailed', 'is_system' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'label' => 'SMS', 'is_system' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'label' => 'Email & SMS', 'is_system' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Permissions Seed
        \App\Models\Permission::create(array(
            'id' => '19',
            'name'  => 'create_event',
            'label' => 'Can create a new event'
        ));
        \App\Models\Permission::create(array(
            'id' => '20',
            'name'  => 'read_event',
            'label' => 'Can view all events'
        ));
        \App\Models\Permission::create(array(
            'id' => '21',
            'name'  => 'update_event',
            'label' => 'Can update an event\'s information'
        ));
        \App\Models\Permission::create(array(
            'id' => '22',
            'name'  => 'delete_event',
            'label' => 'Can remove an event'
        ));
        \App\Models\Permission::create(array(
            'id' => '23',
            'name'  => 'create_invite',
            'label' => 'Can create a new invite'
        ));
        \App\Models\Permission::create(array(
            'id' => '24',
            'name'  => 'read_invite',
            'label' => 'Can view all invites'
        ));
        \App\Models\Permission::create(array(
            'id' => '25',
            'name'  => 'update_invite',
            'label' => 'Can update an invite'
        ));
        \App\Models\Permission::create(array(
            'id' => '26',
            'name'  => 'delete_invite',
            'label' => 'Can remove an invite'
        ));

        // Roles Seed
        \App\Models\Role::create(array(
            'id' => '6',
            'name'  => 'coordinator',
            'label' => 'Coordinator',
        ));

        \App\Models\Role::create(array(
            'id' => '7',
            'name'  => 'schedule',
            'label' => 'Scheduler',
        ));

        // Add Permissions to Roles
        DB::table('permission_role')->insert(array(
            // coordinators
            array('role_id' => 6, 'permission_id' => 2, 'created_at' => now()),
            array('role_id' => 6, 'permission_id' => 5, 'created_at' => now()),
            array('role_id' => 6, 'permission_id' => 6, 'created_at' => now()),
            array('role_id' => 6, 'permission_id' => 7, 'created_at' => now()),
            array('role_id' => 6, 'permission_id' => 19, 'created_at' => now()),
            array('role_id' => 6, 'permission_id' => 20, 'created_at' => now()),
            array('role_id' => 6, 'permission_id' => 21, 'created_at' => now()),
            array('role_id' => 6, 'permission_id' => 24, 'created_at' => now()),

            // schedulers
            array('role_id' => 7, 'permission_id' => 2, 'created_at' => now()),
            array('role_id' => 7, 'permission_id' => 6, 'created_at' => now()),
            array('role_id' => 7, 'permission_id' => 24, 'created_at' => now()),
            array('role_id' => 7, 'permission_id' => 25, 'created_at' => now()),

            // clerks
            array('role_id' => 2, 'permission_id' => 24, 'created_at' => now()),

            // vaccinator
            array('role_id' => 5, 'permission_id' => 20, 'created_at' => now()),
            array('role_id' => 5, 'permission_id' => 24, 'created_at' => now()),

            // managers
            array('role_id' => 3, 'permission_id' => 19, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 20, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 21, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 22, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 23, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 24, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 25, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 26, 'created_at' => now()),

            // admin
            array('role_id' => 4, 'permission_id' => 19, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 20, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 21, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 22, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 23, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 24, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 25, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 26, 'created_at' => now()),
        ));
    }
}
