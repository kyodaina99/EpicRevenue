<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPostbacksHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_postbacks_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('postback_id');
            $table->string('subid1');
            $table->string('subid2');
            $table->string('subid3');
            $table->string('subid4');
            $table->string('subid5');
            $table->string('url_loaded');
            $table->string('url_response');
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
        Schema::drop('user_postbacks_history');
    }
}
