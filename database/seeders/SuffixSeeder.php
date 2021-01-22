<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuffixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Suffix::create(array(
            'id' => '1',
            'display_name'  => 'Jr.'
        ));
        \App\Models\Suffix::create(array(
            'id' => '2',
            'display_name'  => 'Sr.'
        ));
        \App\Models\Suffix::create(array(
            'id' => '3',
            'display_name'  => '2nd'
        ));
        \App\Models\Suffix::create(array(
            'id' => '4',
            'display_name'  => '3rd'
        ));
        \App\Models\Suffix::create(array(
            'id' => '5',
            'display_name'  => 'II'
        ));
        \App\Models\Suffix::create(array(
            'id' => '6',
            'display_name'  => 'III'
        ));
        \App\Models\Suffix::create(array(
            'id' => '7',
            'display_name'  => 'IV'
        ));
        \App\Models\Suffix::create(array(
            'id' => '8',
            'display_name'  => 'V'
        ));
        \App\Models\Suffix::create(array(
            'id' => '9',
            'display_name'  => 'VI'
        ));
    }
}
