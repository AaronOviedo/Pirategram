<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catUser', function (Blueprint $table) {
            $table->increments('intUserID');
            $table->string('strName');
            $table->string('strEmail')->unique();
            $table->string('strPassword');
            $table->datetime('dateBirth');
            $table->string('strGender');
            $table->string('strUserDescription');
            $table->string('strRouteProfile');
            $table->string('strRouteCover');            
            $table->rememberToken();
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
        Schema::dropIfExists('catUser');
    }
}
