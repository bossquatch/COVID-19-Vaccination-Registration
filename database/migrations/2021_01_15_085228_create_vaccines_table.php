<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_id');
            $table->unsignedBigInteger('vaccine_type_id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->unsignedBigInteger('injection_site_id');
            $table->unsignedBigInteger('injection_route_id');
            $table->unsignedBigInteger('eligibility_id');
            $table->date('date_given');
            $table->string('lot_number');
            $table->string('ndc');
            $table->smallInteger('exp_month');
            $table->smallInteger('exp_year');
            $table->date('vis_publication')->nullable();
            $table->string('giver_fname')->nullable();
            $table->string('giver_lname')->nullable();
            $table->string('giver_creds')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('registration_id')
                ->references('id')
                ->on('registrations');

            $table->foreign('vaccine_type_id')
                ->references('id')
                ->on('vaccine_types');

            $table->foreign('manufacturer_id')
                ->references('id')
                ->on('manufacturers');

            $table->foreign('injection_site_id')
                ->references('id')
                ->on('injection_sites');

            $table->foreign('injection_route_id')
                ->references('id')
                ->on('injection_routes');

            $table->foreign('eligibility_id')
                ->references('id')
                ->on('eligibilities');
        });

        Schema::create('risk_factor_vaccine', function (Blueprint $table) {
            // Making the foreign key combo be primary results in a name that is too long
            $table->primary(['risk_factor_id', 'vaccine_id']);

            $table->unsignedBigInteger('risk_factor_id');
            $table->unsignedBigInteger('vaccine_id');
            $table->timestamps();

            $table->foreign('risk_factor_id')
                ->references('id')
                ->on('risk_factors')
                ->onDelete('cascade');

            $table->foreign('vaccine_id')
                ->references('id')
                ->on('vaccines')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_factor_vaccine');
        Schema::dropIfExists('vaccines');
    }
}
