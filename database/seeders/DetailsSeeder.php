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
            'name'  => 'Caucasian'
        ));
        \App\Models\Race::create(array(
            'id' => '2',
            'name'  => 'Hispanic or Latino'
        ));
        \App\Models\Race::create(array(
            'id' => '3',
            'name'  => 'African American'
        ));
        \App\Models\Race::create(array(
            'id' => '4',
            'name'  => 'Native American or American Indian'
        ));
        \App\Models\Race::create(array(
            'id' => '5',
            'name'  => 'Asian or Pacific Islander'
        ));
        \App\Models\Race::create(array(
            'id' => '6',
            'name'  => 'Other'
        ));

        // Genders
        \App\Models\Gender::create(array(
            'id' => '1',
            'name'  => 'Male'
        ));
        \App\Models\Gender::create(array(
            'id' => '2',
            'name'  => 'Female'
        ));
    }
}
