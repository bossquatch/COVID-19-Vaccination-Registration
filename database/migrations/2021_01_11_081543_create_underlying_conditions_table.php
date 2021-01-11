<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnderlyingConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conditions', function (Blueprint $table) {
            $table->id();
            $table->string('condition');
            $table->string('display_name')->nullable();
            $table->integer('score');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('condition_registration', function (Blueprint $table) {
            // Making the foreign key combo be primary results in a name that is too long
            $table->primary(['condition_id', 'registration_id']);

            $table->unsignedBigInteger('registration_id');
            $table->unsignedBigInteger('condition_id');
            $table->timestamps();

            $table->foreign('registration_id')
                ->references('id')
                ->on('registrations')
                ->onDelete('cascade');

            $table->foreign('condition_id')
                ->references('id')
                ->on('conditions')
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
        Schema::dropIfExists('condition_registration');
        Schema::dropIfExists('conditions');
    }
}
