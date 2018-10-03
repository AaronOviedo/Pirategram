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
            $table->increments('id');
            
            $table->string('strName');
            $table->string('strEmail')->unique();
            $table->string('strPassword');
            $table->timestamp('dateBirth', 0);
            $table->string('strGender');
            $table->string('strUserDescription');
            $table->integer('intProfile');
            $table->integer('intCover');        
                
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
