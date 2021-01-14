<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuffixForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'suffix')) {
                $table->unsignedBigInteger('suffix_id')->nullable();
            }

            $table->foreign('suffix_id')->references('id')->on('suffixes');
        });

        Schema::table('registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('registrations', 'suffix')) {
                $table->unsignedBigInteger('suffix_id')->nullable();
            }

            $table->foreign('suffix_id')->references('id')->on('suffixes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['suffix_id']);
        });
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['suffix_id']);
        });
    }
}
