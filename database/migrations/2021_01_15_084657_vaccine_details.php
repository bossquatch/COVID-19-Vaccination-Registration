<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VaccineDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccine_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('manufacturers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('abbrev')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('injection_sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->string('abbrev')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('injection_routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->string('abbrev')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('eligibilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->string('abbrev')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('risk_factors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccine_types');
        Schema::dropIfExists('manufacturers');
        Schema::dropIfExists('injection_sites');
        Schema::dropIfExists('injection_routes');
        Schema::dropIfExists('eligibilities');
        Schema::dropIfExists('risk_factors');
    }
}
