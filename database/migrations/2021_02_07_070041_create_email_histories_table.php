<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('registration_id')->nullable();
            $table->decimal('timestamp',16,6)->nullable();
            $table->string('token',100)->nullable();
            $table->string('signature',100)->nullable();
            $table->string('tags', 200)->nullable();
            $table->string('envelope_sending_ip',15)->nullable();
            $table->string('envelope_sender', 100)->nullable();
            $table->string('envelope_targets', 150)->nullable();
            $table->string('headers_to', 150)->nullable();
            $table->string('headers_message_id', 150)->nullable();
            $table->string('headers_from', 150)->nullable();
            $table->string('headers_subject', 150)->nullable();
            $table->string('recipient', 150)->nullable();
            $table->string('event', 150)->nullable();
            $table->integer('delivery_status_code')->nullable();
            $table->string('delivery_status_message',260)->nullable();
            $table->string('severity', 100)->nullable();
            $table->timestamps();
            $table->softDeletes()->nullable();

            $table->foreign('user_id')
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
        Schema::dropIfExists('email_histories');
    }
}
