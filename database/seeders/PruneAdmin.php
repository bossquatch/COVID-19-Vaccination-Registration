<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PruneAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seeder is just to make sure that admins can ONLY access users
        DB::table('permission_role')
            ->where('role_id', '=', '4')
            ->whereIn('permission_id', [
                1,	    // create_registration
                2,	    // read_registration
                3,	    // update_registration
                4,	    // delete_registration
                5,	    // create_location
                6,	    // read_location
                7,	    // update_location
                8,	    // delete_location
                14,	    // keep_inventory
                15,	    // create_vaccine
                16,	    // read_vaccine
                17,	    // update_vaccine
                18,	    // delete_vaccine
                19,	    // create_event
                20,	    // read_event
                21,	    // update_event
                22,	    // delete_event
                23,	    // create_invite
                24,	    // read_invite
                25,	    // update_invite
                26,	    // delete_invite
                27,	    // read_partner_event
                28,	    // manage_partner_event
                30,	    // skeleton_key
            ])->delete();
    }
}
