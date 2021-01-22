<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Races
        \App\Models\Race::create(array(
            'id' => '1',
            'name'  => 'AMERICAN INDIAN/ALASKAN'
        ));
        \App\Models\Race::create(array(
            'id' => '2',
            'name'  => 'ASIAN INDIAN'
        ));
        \App\Models\Race::create(array(
            'id' => '3',
            'name'  => 'BLACK/AFRICAN AMERICAN'
        ));
        \App\Models\Race::create(array(
            'id' => '4',
            'name'  => 'CHINESE'
        ));
        \App\Models\Race::create(array(
            'id' => '5',
            'name'  => 'FILIPINO'
        ));
        \App\Models\Race::create(array(
            'id' => '6',
            'name'  => 'GUAMANIAN/CHARMORRO'
        ));
        \App\Models\Race::create(array(
            'id' => '7',
            'name'  => 'HAWAIIAN'
        ));
        \App\Models\Race::create(array(
            'id' => '8',
            'name'  => 'JAPANESE'
        ));
        \App\Models\Race::create(array(
            'id' => '9',
            'name'  => 'KOREAN'
        ));
        \App\Models\Race::create(array(
            'id' => '10',
            'name'  => 'SAMOAN'
        ));
        \App\Models\Race::create(array(
            'id' => '11',
            'name'  => 'VIETNAMESE'
        ));
        \App\Models\Race::create(array(
            'id' => '12',
            'name'  => 'WHITE'
        ));
        \App\Models\Race::create(array(
            'id' => '13',
            'name'  => 'OTHER ASIAN'
        ));
        \App\Models\Race::create(array(
            'id' => '14',
            'name'  => 'OTHER NONWHITE'
        ));
        \App\Models\Race::create(array(
            'id' => '15',
            'name'  => 'OTHER PACIFIC ISLANDER'
        ));
        \App\Models\Race::create(array(
            'id' => '16',
            'name'  => 'UNKNOWN'
        ));
        \App\Models\Race::create(array(
            'id' => '17',
            'name'  => 'HISPANIC OR HAITIAN ORIGIN'
        ));

        // Genders
        \App\Models\Gender::create(array(
            'id' => '1',
            'name'  => 'MALE'
        ));
        \App\Models\Gender::create(array(
            'id' => '2',
            'name'  => 'FEMALE'
        ));
    }
}
