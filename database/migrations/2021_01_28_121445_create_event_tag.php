<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_tag', function (Blueprint $table) {
            $table->primary(['event_id','tag_id']);

            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
        });

        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'partner_handled')) {
                $table->boolean('partner_handled')->default(0);
            }
        });

        Schema::table('tags', function (Blueprint $table) {
            if (!Schema::hasColumn('tags', 'is_partner')) {
                $table->boolean('is_partner')->default(0);
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
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['partner_handled']);
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn(['is_partner']);
        });
        Schema::dropIfExists('event_tags');
    }
}
