<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PhoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PhoneType::insert([
			['id' => '1', 'name' => 'Call', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '2', 'name' => 'SMS/Text Message', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
