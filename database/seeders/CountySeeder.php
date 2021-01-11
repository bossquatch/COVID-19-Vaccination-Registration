<?php

namespace Database\Seeders;

use App\Models\Condition;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\County::insert([
            ['id' => '1', 'county' => 'Alachua','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '2', 'county' => 'Baker','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '3', 'county' => 'Bay','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '4', 'county' => 'Bradford','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '5', 'county' => 'Brevard','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '6', 'county' => 'Broward','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '7', 'county' => 'Calhoun','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '8', 'county' => 'Charlotte','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '9', 'county' => 'Citrus','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '10', 'county' => 'Clay','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '11', 'county' => 'Collier','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '12', 'county' => 'Columbia','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '13', 'county' => 'Dade','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '14', 'county' => 'Desoto','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '15', 'county' => 'Dixie','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '16', 'county' => 'Duval','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '17', 'county' => 'Escambia','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '18', 'county' => 'Flagler','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '19', 'county' => 'Franklin','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '20', 'county' => 'Gadsden','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '21', 'county' => 'Gilchrist','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '22', 'county' => 'Glades','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '23', 'county' => 'Gulf','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '24', 'county' => 'Hamilton','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '25', 'county' => 'Hardee','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '26', 'county' => 'Hendry','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '27', 'county' => 'Hernando','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '28', 'county' => 'Highlands','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '29', 'county' => 'Hillsborough','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '30', 'county' => 'Holmes','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '31', 'county' => 'Indian River','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '32', 'county' => 'Jackson','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '33', 'county' => 'Jefferson','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '34', 'county' => 'Lafayette','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '35', 'county' => 'Lake','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '36', 'county' => 'Lee','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '37', 'county' => 'Leon','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '38', 'county' => 'Levy','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '39', 'county' => 'Liberty','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '40', 'county' => 'Madison','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '41', 'county' => 'Manatee','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '42', 'county' => 'Marion','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '43', 'county' => 'Martin','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '44', 'county' => 'Monroe','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '45', 'county' => 'Nassau','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '46', 'county' => 'Okaloosa','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '47', 'county' => 'Okeechobee','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '48', 'county' => 'Orange','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '49', 'county' => 'Osceola','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '50', 'county' => 'Palm Beach','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '51', 'county' => 'Pasco','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '52', 'county' => 'Pinellas','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '53', 'county' => 'Polk','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '54', 'county' => 'Putnam','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '55', 'county' => 'Santa Rosa','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '56', 'county' => 'Sarasota','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '57', 'county' => 'Seminole','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '58', 'county' => 'St. Johns','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '59', 'county' => 'St. Lucie','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '60', 'county' => 'Sumter','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '61', 'county' => 'Suwannee','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '62', 'county' => 'Taylor','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '63', 'county' => 'Union','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '64', 'county' => 'Unknown','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '65', 'county' => 'Volusia','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '66', 'county' => 'Wakulla','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '67', 'county' => 'Walton','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '68', 'county' => 'Washington','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '69', 'county' => 'Outside of Florida','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
