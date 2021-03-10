<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmailRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('email_replies', function (Blueprint $table) {
		    $table->uuid('id')->primary();
		    $table->unsignedBigInteger ('user_id')->nullable();
		    $table->string('content_type')->nullable ();
		    $table->dateTime('date')->nullable ();
		    $table->string('from');
		    $table->string('in_reply_to')->nullable();
		    $table->string('message_id')->nullable();
		    $table->string('mime_version')->nullable();
		    $table->string('received')->nullable();
		    $table->string('references')->nullable();
		    $table->string('sender')->nullable();
		    $table->string('subject')->nullable();
		    $table->string('to')->nullable();
		    $table->string('user_agent')->nullable();
		    $table->string('x_mailgun_variables')->nullable();
		    $table->integer('attachment_count')->nullable();
		    $table->text('body_html')->nullable();
		    $table->text('body_plain')->nullable();
		    $table->text('stripped_signature')->nullable();
		    $table->text('stripped_text')->nullable();
		    $table->integer('timestamp')->nullable();
		    $table->string('token')->nullable();
		    $table->text('attachment_1')->nullable();
		    $table->text('attachment_2')->nullable();

		    $table->timestamps();
		    $table->softDeletes ();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('email_replies');
    }
}
