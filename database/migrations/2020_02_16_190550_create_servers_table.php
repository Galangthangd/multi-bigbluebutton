<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('base_url');
            $table->string('sec_secret');
            $table->integer('weight');
            $table->boolean('enabled');
            $table->timestamps();
        });

        DB::table('servers')->insert([
            ['base_url' => 'https://bbb2.hou.edu.vn/bigbluebutton/', 'sec_secret' => 'KYpg0zHpcoji5i0pvgBsluUCMPRqzaglz6XeyHgyoM', 'weight' => 10, 'enabled' => true],
            ['base_url' => 'https://bbb.hou.edu.vn/bigbluebutton/', 'sec_secret' => '41fc827859c6dc3e2ca830144ccaba85', 'weight' => 20, 'enabled' => false]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
