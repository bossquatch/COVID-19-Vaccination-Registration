<?php

namespace Database\Seeders;

use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
	 *
     */
    public function run()
    {
        state::insert([
            ['id' => '1', 'name' => 'Alaska', 'abbr' => 'AK', 'capital' => 'Juneau','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '2', 'name' => 'Alabama', 'abbr' => 'AL', 'capital' => 'Montgomery','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '3', 'name' => 'Arkansas', 'abbr' => 'AR', 'capital' => 'Little Rock','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '4', 'name' => 'Arizona', 'abbr' => 'AZ', 'capital' => 'Phoenix','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '5', 'name' => 'California', 'abbr' => 'CA', 'capital' => 'Sacramento','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '6', 'name' => 'Colorado', 'abbr' => 'CO', 'capital' => 'Denver','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '7', 'name' => 'Connecticut', 'abbr' => 'CT', 'capital' => 'Hartford','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '8', 'name' => 'Delaware', 'abbr' => 'DE', 'capital' => 'Dover','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '9', 'name' => 'Florida', 'abbr' => 'FL', 'capital' => 'Tallahassee','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '10', 'name' => 'Georgia', 'abbr' => 'GA', 'capital' => 'Atlanta','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '11', 'name' => 'Hawaii', 'abbr' => 'HI', 'capital' => 'Honolulu','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '12', 'name' => 'Iowa', 'abbr' => 'IA', 'capital' => 'Des Moines','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '13', 'name' => 'Idaho', 'abbr' => 'ID', 'capital' => 'Boise','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '14', 'name' => 'Illinois', 'abbr' => 'IL', 'capital' => 'Springfield','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '15', 'name' => 'Indiana', 'abbr' => 'IN', 'capital' => 'Indianapolis','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '16', 'name' => 'Kansas', 'abbr' => 'KS', 'capital' => 'Topeka','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '17', 'name' => 'Kentucky', 'abbr' => 'KY', 'capital' => 'Frankfort','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '18', 'name' => 'Louisiana', 'abbr' => 'LA', 'capital' => 'Baton Rouge','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '19', 'name' => 'Massachusetts', 'abbr' => 'MA', 'capital' => 'Boston','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '20', 'name' => 'Maryland', 'abbr' => 'MD', 'capital' => 'Annapolis','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '21', 'name' => 'Maine', 'abbr' => 'ME', 'capital' => 'Augusta','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '22', 'name' => 'Michigan', 'abbr' => 'MI', 'capital' => 'Lansing','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '23', 'name' => 'Minnesota', 'abbr' => 'MN', 'capital' => 'St. Paul','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '24', 'name' => 'Missouri', 'abbr' => 'MO', 'capital' => 'Jefferson City','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '25', 'name' => 'Mississippi', 'abbr' => 'MS', 'capital' => 'Jackson','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '26', 'name' => 'Montana', 'abbr' => 'MT', 'capital' => 'Helena','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '27', 'name' => 'North Carolina', 'abbr' => 'NC', 'capital' => 'Raleigh','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '28', 'name' => 'North Dakota', 'abbr' => 'ND', 'capital' => 'Bismarck','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '29', 'name' => 'Nebraska', 'abbr' => 'NE', 'capital' => 'Lincoln','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '30', 'name' => 'New Hampshire', 'abbr' => 'NH', 'capital' => 'Concord','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '31', 'name' => 'New Jersey', 'abbr' => 'NJ', 'capital' => 'Trenton','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '32', 'name' => 'New Mexico', 'abbr' => 'NM', 'capital' => 'Santa Fe','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '33', 'name' => 'Nevada', 'abbr' => 'NV', 'capital' => 'Carson City','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '34', 'name' => 'New York', 'abbr' => 'NY', 'capital' => 'Albany','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '35', 'name' => 'Ohio', 'abbr' => 'OH', 'capital' => 'Columbus','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '36', 'name' => 'Oklahoma', 'abbr' => 'OK', 'capital' => 'Oklahoma City','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '37', 'name' => 'Oregon', 'abbr' => 'OR', 'capital' => 'Salem','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '38', 'name' => 'Pennsylvania', 'abbr' => 'PA', 'capital' => 'Harrisburg','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '39', 'name' => 'Rhode Island', 'abbr' => 'RI', 'capital' => 'Providence','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '40', 'name' => 'South Carolina', 'abbr' => 'SC', 'capital' => 'Columbia','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '41', 'name' => 'South Dakota', 'abbr' => 'SD', 'capital' => 'Pierre','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '42', 'name' => 'Tennessee', 'abbr' => 'TN', 'capital' => 'Nashville','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '43', 'name' => 'Texas', 'abbr' => 'TX', 'capital' => 'Austin','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '44', 'name' => 'Utah', 'abbr' => 'UT', 'capital' => 'Salt Lake City','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '45', 'name' => 'Virginia', 'abbr' => 'VA', 'capital' => 'Richmond','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '46', 'name' => 'Vermont', 'abbr' => 'VT', 'capital' => 'Montpelier','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '47', 'name' => 'Washington', 'abbr' => 'WA', 'capital' => 'Olympia','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '48', 'name' => 'Wisconsin', 'abbr' => 'WI', 'capital' => 'Madison','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '49', 'name' => 'West Virginia', 'abbr' => 'WV', 'capital' => 'Charleston','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '50', 'name' => 'Wyoming', 'abbr' => 'WY', 'capital' => 'Cheyenne','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '51', 'name' => 'Puerto Rico', 'abbr' => 'PR', 'capital' => 'San Juan','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '52', 'name' => 'Washington, D.C.', 'abbr' => 'DC', 'capital' => '','created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
