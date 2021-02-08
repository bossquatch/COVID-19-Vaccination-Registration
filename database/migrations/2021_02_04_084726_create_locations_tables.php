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

		// remove foreign key constrain from registrations table: registrations_county_id_foreign
		// remove the county relationship from the registration model
//		Schema::table('registrations', function (Blueprint $table) {
//			$table->dropForeign('registrations_county_id_foreign');
//			$table->dropColumn('county_id');
//		});

		// delete tables: address_types, addresses, counties, states
		Schema::dropIfExists('addresses');
		Schema::dropIfExists('address_types');
		Schema::dropIfExists('counties');
		Schema::dropIfExists('states');

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
			$table->string('line_2', 100)->nullable();
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

		// add address_id (unsignedBigInteger, nullable, no default) to the registrations table=
		Schema::table('registrations', function (Blueprint $table) {
			if (!Schema::hasColumn('registrations', 'address_id')) {
				$table->unsignedBigInteger('address_id')->nullable();

				$table->foreign('address_id')
					->references('id')
					->on('addresses')
					->onDelete('set null');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('registrations', function (Blueprint $table) {
			if (Schema::hasColumn('registrations', 'address_id')) {
				$table->dropForeign('registrations_address_id_foreign');
				$table->dropColumn('address_id');
			}
		});

		// delete tables: address_types, addresses, counties, states
		Schema::dropIfExists('addresses');
		Schema::dropIfExists('address_types');
		Schema::dropIfExists('counties');
		Schema::dropIfExists('states');

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
            $table->string('county',50);
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

		// add address_id (unsignedBigInteger, nullable, no default) to the registrations table=
		Schema::table('registrations', function (Blueprint $table) {
			$table->unsignedBigInteger('county_id')->nullable();

			$table->foreign('county_id')
				->references('id')
				->on('counties')
				->onDelete('set null');
		});
	}
}
