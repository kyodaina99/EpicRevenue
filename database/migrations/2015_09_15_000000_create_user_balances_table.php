<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_balances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->decimal('cash',15,4)->default(0.0000);
            $table->decimal('referral',15,4)->default(0.0000);
            $table->bigInteger('points')->default(0);
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
        Schema::table('user_balances', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::drop('user_balances');
    }
}
