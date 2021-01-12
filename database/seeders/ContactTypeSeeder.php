<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ContactType::insert([
			['id' => '1', 'name' => 'Email', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '2', 'name' => 'Phone', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
