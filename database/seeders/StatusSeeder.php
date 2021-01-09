<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Status::insert([
            ['id' => '1', 'name' => 'In Wait List', 'fa_icon' => 'fad fa-sync text-secondary', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '2', 'name' => 'Appointment Pending', 'fa_icon' => 'fad fa-exclamation-triangle text-warning', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '3', 'name' => 'Scheduled', 'fa_icon' => 'fad fa-calendar-alt text-info', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '4', 'name' => 'Checked In', 'fa_icon' => 'fad fa-check-circle text-primary', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '5', 'name' => 'Completed', 'fa_icon' => 'fad fa-check-circle text-success', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '6', 'name' => 'Rejected', 'fa_icon' => 'fad fa-times-circle text-danger', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '7', 'name' => 'Appointment Declined', 'fa_icon' => 'fad fa-times-circle text-warning', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '8', 'name' => 'No Response', 'fa_icon' => 'fad fa-comment-alt-slash text-warning', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '9', 'name' => 'Absent', 'fa_icon' => 'fad fa-minus-circle text-danger', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '10', 'name' => 'Cancelled', 'fa_icon' => 'fad fa-ban text-info', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
