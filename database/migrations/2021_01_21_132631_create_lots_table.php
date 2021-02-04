<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('number', 31);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('event_lot', function (Blueprint $table) {
            $table->primary(['event_id','lot_id']);

            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('lot_id');
            $table->timestamps();

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');

            $table->foreign('lot_id')
                ->references('id')
                ->on('lots')
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
        Schema::dropIfExists('event_lot');
        Schema::dropIfExists('lots');
    }
}
