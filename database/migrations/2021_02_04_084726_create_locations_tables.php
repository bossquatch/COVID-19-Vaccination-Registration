<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTables extends Migration
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

		Schema::create('counties', function (Blueprint $table) {
			$table->id();
			$table->string('name',50);
			$table->unsignedBigInteger('state_id');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('state_id')
				->references('id')
				->on('states')
				->onDelete('cascade');

		});

		Schema::create('address_types', function (Blueprint $table) {
			$table->id();
			$table->string('type',100)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('addresses', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('address_type_id');
			$table->integer('street_number');
			$table->string('street_name', 100);
			$table->string('line_2', 100);
			$table->string('locality', 100);
			$table->unsignedBigInteger('county_id')->nullable();
			$table->unsignedBigInteger('state_id')->nullable();
			$table->string('postal_code', 25)->nullable();
			$table->decimal('latitude',10,8)->nullable();
			$table->decimal('longitude',11,8)->nullable();
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
		Schema::dropIfExists('address_types');
		Schema::dropIfExists('counties');
		Schema::dropIfExists('states');
	}
}
