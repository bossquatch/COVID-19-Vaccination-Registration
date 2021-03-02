<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingsRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condition_settings', function (Blueprint $table) {
            // Making the foreign key combo be primary results in a name that is too long
            $table->primary(['condition_id', 'settings_id']);

            $table->unsignedBigInteger('settings_id');
            $table->unsignedBigInteger('condition_id');
            $table->timestamps();

            $table->foreign('settings_id')
                ->references('id')
                ->on('settings')
                ->onDelete('cascade');

            $table->foreign('condition_id')
                ->references('id')
                ->on('conditions')
                ->onDelete('cascade');
        });

        Schema::create('occupation_settings', function (Blueprint $table) {
            // Making the foreign key combo be primary results in a name that is too long
            $table->primary(['occupation_id', 'settings_id']);

            $table->unsignedBigInteger('settings_id');
            $table->unsignedBigInteger('occupation_id');
            $table->timestamps();

            $table->foreign('settings_id')
                ->references('id')
                ->on('settings')
                ->onDelete('cascade');

            $table->foreign('occupation_id')
                ->references('id')
                ->on('occupations')
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
        Schema::dropIfExists('condition_settings');
        Schema::dropIfExists('occupation_settings');
    }
}
