<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccineDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaccine Types
        \App\Models\VaccineType::insert([
            ['id' => 1, 'name' => 'COVID-19 MODERNA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'COVID-19 PFIZER', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'COVID-19 UNK', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Eligibilities
        \App\Models\Eligibility::insert([
            ['id' => 1, 'description' => 'COVID-19 NON-VFC PRIVATELY INSURED', 'abbrev' => 'FLSHOTS071', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'description' => 'COVID-19 NON-VFC UNDERINSURED', 'abbrev' => 'FLSHOTS072', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'description' => 'COVID-19 NON-VFC UNINSURED', 'abbrev' => 'FLSHOTS073', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'description' => 'COVID-19 UNSPECIFIED ELIGIBILITY', 'abbrev' => 'FLSHOTS074', 'created_at' => now(), 'updated_at' => now()],
        ]); 

        // Injection Routes
        \App\Models\InjectionRoute::insert([
            ['id' => 1, 'description' => 'INTRADERMAL', 'abbrev' => 'ID', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'description' => 'INTRAMUSCULAR', 'abbrev' => 'IM', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'description' => 'INTRAVENOUS', 'abbrev' => 'IV', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'description' => 'PERCUTANEOUS', 'abbrev' => 'PCT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'description' => 'SUBCUTANEOUS', 'abbrev' => 'SC', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'description' => 'TRANSDERMAL', 'abbrev' => 'TRD', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'description' => 'OTHER', 'abbrev' => 'OTH', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
        ]); 

        // Injection Sites
        \App\Models\InjectionSite::insert([
            ['id' => 1, 'description' => 'LEFT ANTERIOR THIGH', 'abbrev' => 'LAT', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 2, 'description' => 'LEFT ARM', 'abbrev' => 'LA', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 3, 'description' => 'LEFT DELTOID', 'abbrev' => 'LDT', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 4, 'description' => 'LEFT DELTOID', 'abbrev' => 'LD', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'description' => 'LEFT GLUTEOUS MEDIUS', 'abbrev' => 'LG', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 6, 'description' => 'LEFT LATERAL THIGH', 'abbrev' => 'LLT', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 7, 'description' => 'LEFT LOWER FOREARM', 'abbrev' => 'LLFA', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 8, 'description' => 'LEFT THIGH', 'abbrev' => 'LT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'description' => 'LEFT TRICEPS', 'abbrev' => 'LTR', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 10, 'description' => 'LEFT VASTUS LATERALIS', 'abbrev' => 'LVL', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 11, 'description' => 'RIGHT ANTERIOR THIGH', 'abbrev' => 'RAT', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 12, 'description' => 'RIGHT ARM', 'abbrev' => 'RA', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 13, 'description' => 'RIGHT DELTOID', 'abbrev' => 'RDT', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 14, 'description' => 'RIGHT DELTOID', 'abbrev' => 'RD', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'description' => 'RIGHT GLUTEOUS MEDIUS', 'abbrev' => 'RG', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 16, 'description' => 'RIGHT LATERAL THIGH', 'abbrev' => 'RLT', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 17, 'description' => 'RIGHT LOWER FOREARM', 'abbrev' => 'RLFA', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 18, 'description' => 'RIGHT THIGH', 'abbrev' => 'RT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'description' => 'RIGHT TRICEPS', 'abbrev' => 'RTR', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
            ['id' => 20, 'description' => 'RIGHT VASTUS LATERALIS', 'abbrev' => 'RVL', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
        ]); 

        // Manufacturers
        \App\Models\Manufacturer::insert([
            ['id' => 1, 'name' => 'MODERNA US, INC.', 'abbrev' => 'MOD', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'PFIZER, INC', 'abbrev' => 'PFR', 'created_at' => now(), 'updated_at' => now()],
        ]); 

        // Risk Factors
        \App\Models\RiskFactor::insert([
            ['id' => 1, 'name' => 'AGE 65+ (EXCLUDING LTCF)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'HEALTH CARE PERSONNEL', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'LTCF RESIDENT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'LTCF STAFF', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'UNKNOWN', 'created_at' => now(), 'updated_at' => now()],
        ]); 

        // New Role and Permissions update
        \App\Models\Role::create(array(
            'id' => '5',
            'name'  => 'vac',
            'label' => 'Vaccinator',
        ));

        \App\Models\Permission::create(array(
            'id' => '15',
            'name'  => 'create_vaccine',
            'label' => 'Can create a new vaccine'
        ));
        \App\Models\Permission::create(array(
            'id' => '16',
            'name'  => 'read_vaccine',
            'label' => 'Can view all vaccines'
        ));
        \App\Models\Permission::create(array(
            'id' => '17',
            'name'  => 'update_vaccine',
            'label' => 'Can update a vaccine\'s information'
        ));
        \App\Models\Permission::create(array(
            'id' => '18',
            'name'  => 'delete_vaccine',
            'label' => 'Can remove a vaccine'
        ));

        DB::table('permission_role')->insert(array(
            // vaccinators
            array('role_id' => 5, 'permission_id' => 2, 'created_at' => now()),
            array('role_id' => 5, 'permission_id' => 6, 'created_at' => now()),
            array('role_id' => 5, 'permission_id' => 15, 'created_at' => now()),
            array('role_id' => 5, 'permission_id' => 16, 'created_at' => now()),
            array('role_id' => 5, 'permission_id' => 17, 'created_at' => now()),

            // managers
            array('role_id' => 3, 'permission_id' => 15, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 16, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 17, 'created_at' => now()),
            array('role_id' => 3, 'permission_id' => 18, 'created_at' => now()),

            // admin
            array('role_id' => 4, 'permission_id' => 15, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 16, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 17, 'created_at' => now()),
            array('role_id' => 4, 'permission_id' => 18, 'created_at' => now()),
        ));
    }
}
