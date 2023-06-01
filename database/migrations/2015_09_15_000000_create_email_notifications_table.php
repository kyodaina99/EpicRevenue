<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->enum('newsletters', ['yes', 'no'])->default('yes');
            $table->enum('leads', ['yes', 'no'])->default('yes');
            $table->enum('shoutouts', ['yes', 'no'])->default('yes');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_notifications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::drop('email_notifications');
    }
}
