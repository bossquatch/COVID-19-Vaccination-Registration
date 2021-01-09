<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->smallInteger('phase');
            $table->char('phase_classification');
            $table->timestamps();
        });

        Schema::create('agreement_registration', function (Blueprint $table) {
            $table->primary(['agreement_id','registration_id']);

            $table->unsignedBigInteger('agreement_id');
            $table->unsignedBigInteger('registration_id');
            $table->timestamps();

            $table->foreign('agreement_id')
                ->references('id')
                ->on('agreements')
                ->onDelete('cascade');

            $table->foreign('registration_id')
                ->references('id')
                ->on('registrations')
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
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('agreements');
    }
}
