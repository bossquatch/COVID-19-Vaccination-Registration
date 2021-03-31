<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVistorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vistors', function (Blueprint $table) {
            $table->id();
            $table->string ('location',100)->nullable ();
	        $table->string ('visitor_name',100)->nullable ();
	        $table->string ('visitor_phone',20)->nullable ();
	        $table->string ('visitor_email',100)->nullable ();
	        $table->string ('host_name',100)->nullable ();
	        $table->string ('host_email',100)->nullable ();
	        $table->timestamp('sign_in_time')->nullable ();
	        $table->string ('thumbnail',1024)->nullable ();
	        $table->string ('visitor_entity',100)->nullable ();
	        $table->string ('visitor_reason',100)->nullable ();

            $table->timestamps();
            $table->softDeletes ();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vistors');
    }
}
