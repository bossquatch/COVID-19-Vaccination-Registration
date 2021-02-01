<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('abbr',100)->nullable();
            $table->string('capital',50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_types', function (Blueprint $table) {
            $table->id();
            $table->string('type',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('line_1',100)->nullable();
            $table->string('line_2',100)->nullable();
            $table->string('city',50)->nullable();
            $table->unsignedBigInteger('county_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('zip_code', 25)->nullable();
            $table->decimal('latitude',10,8)->nullable();
            $table->decimal('longitude',11,8)->nullable();
            $table->unsignedBigInteger('address_type_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('cascade');
            $table->foreign('county_id')
                ->references('id')
                ->on('counties')
                ->onDelete('cascade');
            $table->foreign('address_type_id')
                ->references('id')
                ->on('address_types')
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
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('states');
    }
}
