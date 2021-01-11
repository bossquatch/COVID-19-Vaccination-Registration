<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_id')->default(1);
            $table->unsignedBigInteger('race_id');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('occupation_id');
            $table->unsignedBigInteger('county_id');
            
            // Obtained by user account:
            $table->string('first_name');
            $table->string('middle_name', 30)->nullable();
            $table->string('last_name');
            // replaced by 'contacts' table
            //$table->string('email')->unique();
            //$table->string('phone');
            $table->date('birth_date');

            // New Info
            $table->string('address1',60)->nullable();
            $table->string('address2',60)->nullable();
            $table->string('city',60)->nullable();
            $table->char('state',2)->nullable();
            $table->string('zip',14)->nullable();
            $table->boolean('prefer_close_location')->default(0);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onDelete('cascade');

            $table->foreign('race_id')
                ->references('id')
                ->on('races')
                ->onDelete('cascade');

            $table->foreign('gender_id')
                ->references('id')
                ->on('genders')
                ->onDelete('cascade');

            $table->foreign('occupation_id')
                ->references('id')
                ->on('occupations')
                ->onDelete('cascade');

            $table->foreign('county_id')
                ->references('id')
                ->on('counties')
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
    }
}
