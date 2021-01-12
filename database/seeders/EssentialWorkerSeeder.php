<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EssentialWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Occupation::insert([
			['id' => '1', 'sector' => 'CHEMICAL', 'display_name' => 'Chemical', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '2', 'sector' => 'COMMERCIAL FACILITIES', 'display_name' => 'Commercial Facilities', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '3', 'sector' => 'COMMUNICATIONS AND INFORMATION TECHNOLOGY', 'display_name' => 'Communications And Information Technology', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '4', 'sector' => 'CRITICAL MANUFACTURING', 'display_name' => 'Critical Manufacturing', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '5', 'sector' => 'DEFENSE INDUSTRIAL BASE', 'display_name' => 'Defense Industrial Base', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '6', 'sector' => 'EDUCATION', 'display_name' => 'Education', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '7', 'sector' => 'ENERGY', 'display_name' => 'Energy', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '8', 'sector' => 'FINANCIAL SERVICES', 'display_name' => 'Financial Services', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '9', 'sector' => 'FOOD AND AGRICULTURE', 'display_name' => 'Food And Agriculture', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '10', 'sector' => 'HAZARDOUS MATERIALS ', 'display_name' => 'Hazardous Materials ', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '11', 'sector' => 'HEALTHCARE / PUBLIC HEALTH', 'display_name' => 'Healthcare / Public Health', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '12', 'sector' => 'HYGIENE PRODUCTS AND SERVICES', 'display_name' => 'Hygiene Products And Services', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '13', 'sector' => 'LAW ENFORCEMENT, PUBLIC SAFETY, AND OTHER FIRST RESPONDERS', 'display_name' => 'Law Enforcement, Public Safety, And Other First Responders', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '14', 'sector' => 'OTHER COMMUNITY- OR GOVERNMENT-BASED OPERATIONS AND ESSENTIAL FUNCTIONS ', 'display_name' => 'Other Community- Or Government-Based Operations And Essential Functions ', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '15', 'sector' => 'PUBLIC WORKS AND INFRASTRUCTURE SUPPORT SERVICES', 'display_name' => 'Public Works And Infrastructure Support Services', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '16', 'sector' => 'RESIDENTIAL/SHELTER FACILITIES, HOUSING AND REAL ESTATE, AND RELATED SERVICES', 'display_name' => 'Residential/Shelter Facilities, Housing And Real Estate, And Related Services', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '17', 'sector' => 'TRANSPORTATION AND LOGISTICS ', 'display_name' => 'Transportation And Logistics ', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '18', 'sector' => 'WATER AND WASTEWATER', 'display_name' => 'Water And Wastewater', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '19', 'sector' => 'OTHER NOT ON THIS LIST', 'display_name' => 'Other Not On This List', 'score' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
