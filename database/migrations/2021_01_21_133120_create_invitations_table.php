<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->primary(['slot_id','registration_id']);

            $table->unsignedBigInteger('slot_id');
            $table->unsignedBigInteger('registration_id');
            $table->unsignedBigInteger('invite_status_id')->default(1);
            $table->unsignedBigInteger('contact_method_id')->nullable();
            $table->unsignedBigInteger('contacted_by')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('slot_id')
                ->references('id')
                ->on('slots')
                ->onDelete('cascade');
                
            $table->foreign('registration_id')
                ->references('id')
                ->on('registrations')
                ->onDelete('cascade');

            $table->foreign('invite_status_id')
                ->references('id')
                ->on('invite_statuses')
                ->onDelete('cascade');

            $table->foreign('contact_method_id')
                ->references('id')
                ->on('contact_methods')
                ->onDelete('cascade');

            $table->foreign('contacted_by')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('invitations');
    }
}
