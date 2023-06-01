<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBalanceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_balance_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_balance_id')->unsigned()->index();
            $table->integer('referrer_id')->nullable()->default(null);
            $table->enum('type', ['cash', 'referral', 'points']);
            $table->enum('operation', ['add', 'withdraw']);
            $table->decimal('amount',15,4)->default(0.0000);
            $table->timestamps();

            $table->foreign('user_balance_id')
                ->references('id')->on('user_balances')
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
        Schema::table('user_balance_histories', function (Blueprint $table) {
            $table->dropForeign(['user_balance_id']);
        });
        Schema::drop('user_balance_histories');
    }
}
