<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StatusSeeder::class,
            PermissionsSeeder::class,
            RolesSeeder::class,
            RolesPermissionSeeder::class,
            DetailsSeeder::class,
            EssentialWorkerSeeder::class,
            UnderlyingConditionSeeder::class,
            UserSeeder::class,
            ContactTypeSeeder::class,
            PhoneTypeSeeder::class,
			LocationsSeeder::class,
			AttendantSeeder::class,
			EssentialWorkerSeeder::class,
			PartnerSeeder::class,
			PruneAdmin::class,
			SchedulingLookupSeeder::class,
			SuffixSeeder::class,
			VaccineDetailsSeeder::class,
        ]);
    }
}
