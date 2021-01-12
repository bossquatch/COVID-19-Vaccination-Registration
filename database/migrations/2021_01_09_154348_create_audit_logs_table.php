<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('regis_id')->nullable();
            $table->unsignedBigInteger('auditable_id');
            $table->string('auditable_type');
            $table->longtext('json_description');
            $table->longtext('json_ips');
            $table->timestamps();
            $table->softDeletes();

            // table->foreign() not set to make sure that this info is always available and easily accessible
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
}
