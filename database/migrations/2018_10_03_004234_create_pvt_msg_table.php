<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePvtMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relPvtMsg', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('intReceive');  //User who receive the private message
            $table->integer('intSend');     //User who send the private message
            $table->string('strMessage');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relPvtMsg');
    }
}
