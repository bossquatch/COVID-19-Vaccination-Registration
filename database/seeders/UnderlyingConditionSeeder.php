<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UnderlyingConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Condition::insert([
			['id' => '1', 'condition' => 'Asthma (moderate-to-severe)', 'display_name' => 'Asthma', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '2', 'condition' => 'Cancer', 'display_name' => 'Cancer', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '3', 'condition' => 'Cerebrovascular disease (affects blood vessels and blood supply to the brain)', 'display_name' => 'Cerebrovascular disease', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '4', 'condition' => 'Chronic kidney disease', 'display_name' => 'Chronic kidney disease', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '5', 'condition' => 'COPD (chronic obstructive pulmonary disease)', 'display_name' => 'COPD', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '6', 'condition' => 'Cystic fibrosis', 'display_name' => 'Cystic fibrosis', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '7', 'condition' => 'Down Syndrome', 'display_name' => 'Down Syndrome', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '8', 'condition' => 'Heart conditions, such as heart failure, coronary artery disease, or cardiomyopathies', 'display_name' => 'Heart conditions', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '9', 'condition' => 'Hypertension or high blood pressure', 'display_name' => 'Hypertension or high blood pressure', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '10', 'condition' => 'Immunocompromised state (weakened immune system) from blood or bone marrow transplant, immune deficiencies, HIV, use of corticosteroids, or use of other immune weakening medicines', 'display_name' => 'Immunocompromised state', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '11', 'condition' => 'Immunocompromised state (weakened immune system) from solid organ transplant', 'display_name' => 'Solid organ transplant', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '12', 'condition' => 'Liver disease', 'display_name' => 'Liver disease', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '13', 'condition' => 'Neurologic conditions, such as dementia', 'display_name' => 'Neurologic conditions, such as dementia', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '14', 'condition' => 'Obesity (body mass index [BMI] of 30 kg/m2 or higher but < 40 kg/m2)', 'display_name' => 'Obesity', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '15', 'condition' => 'Overweight (BMI > 25 kg/m2, but < 30 kg/m2)', 'display_name' => 'Overweight', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '16', 'condition' => 'Pregnancy', 'display_name' => 'Pregnancy', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '17', 'condition' => 'Pulmonary fibrosis (having damaged or scarred lung tissues)', 'display_name' => 'Pulmonary fibrosis', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '18', 'condition' => 'Sickle cell disease', 'display_name' => 'Sickle cell disease', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '19', 'condition' => 'Smoking', 'display_name' => 'Smoking', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '20', 'condition' => 'Thalassemia (a type of blood disorder)', 'display_name' => 'Thalassemia', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '21', 'condition' => 'Type 1 diabetes mellitus', 'display_name' => 'Type 1 diabetes mellitus', 'score' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '22', 'condition' => 'Type 2 diabetes mellitus', 'display_name' => 'Type 2 diabetes mellitus', 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			['id' => '23', 'condition' => 'Severe Obesity (BMI ≥ 40 kg/m2)', 'display_name' => null, 'score' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
