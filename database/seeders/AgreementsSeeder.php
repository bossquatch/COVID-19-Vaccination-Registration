<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgreementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Agreement::create([
            'id' => '1',
            'text'  => 'I am a long term care facility worker.',
            'phase' => '1',
            'phase_classification' => 'A',
        ]);
        \App\Models\Agreement::create([
            'id' => '2',
            'text'  => 'I am a heatlhcare worker.',
            'phase' => '1',
            'phase_classification' => 'B',
        ]);
    }
}
