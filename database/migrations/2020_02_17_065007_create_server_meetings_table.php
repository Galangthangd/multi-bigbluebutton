<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('server_id')->unsigned();
            $table->string('meeting_id');
            $table->string('meeting_name');
            $table->string('status');
            $table->dateTime('start_time');
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_server');
    }
}
