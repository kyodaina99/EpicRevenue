<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailchimpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailchimps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('list_id');
            $table->string('email_address')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->enum('status', ['subscribed', 'unsubscribed'])->nullable()->default(null);
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
        Schema::drop('mailchimps');
    }
}
