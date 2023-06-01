<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ips')->nullable();
            $table->string('ch_slot');
            $table->string('reverse_var')->nullable();
            $table->integer('reverse_key')->nullable();
            $table->string('veri_slot');
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
        Schema::drop('postbacks');
    }
}
