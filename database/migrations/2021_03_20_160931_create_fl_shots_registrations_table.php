<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlShotsRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fl_shots_registrations', function (Blueprint $table) {
        	$table->primary (['registration_id','fl_shots_id']);
            $table->unsignedBigInteger('registration_id');
	        $table->unsignedBigInteger('fl_shots_id');
            $table->timestamps();

            $table->foreign('registration_id')
	            ->references('id')
	            ->on('registrations')
                ->onDelete ('cascade');
            $table->foreign ('fl_shots_id')
	            ->references ('id')
	            ->on('fl_shots')
	            ->onDelete ('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fl_shots_registrations');
    }
}
