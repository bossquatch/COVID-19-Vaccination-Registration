<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_id');
            $table->unsignedBigInteger('contact_type_id');
            $table->unsignedBigInteger('phone_type_id')->nullable();
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('registration_id')
                ->references('id')
                ->on('registrations')
                ->onDelete('cascade');

            $table->foreign('contact_type_id')
                ->references('id')
                ->on('contact_types')
                ->onDelete('cascade');

            $table->foreign('phone_type_id')
                ->references('id')
                ->on('phone_types')
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
        Schema::dropIfExists('contacts');
    }
}
