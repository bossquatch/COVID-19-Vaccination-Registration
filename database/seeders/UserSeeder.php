<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create(array(
            'first_name' => 'Benjamin',
            'last_name' => 'Harvey',
            'email' => 'BenjaminHarvey@polk-county.net',
            'password' => Hash::make(config('app.default_password')),
            'email_verified_at' => Carbon::now()
        ));
        $user->assignRole('admin');

        $user = \App\Models\User::create(array(
            'first_name' => 'Douglas',
            'last_name' => 'Cockerham',
            'email' => 'DouglasCockerham@polk-county.net',
            'password' => Hash::make(config('app.default_password')),
            'email_verified_at' => Carbon::now()
        ));
        $user->assignRole('admin');
    }
}
