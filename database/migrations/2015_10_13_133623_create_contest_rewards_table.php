<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contest_id')->unsigned()->index();
            $table->integer('position');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->timestamps();

            $table->foreign('contest_id')
                ->references('id')->on('contests')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contest_rewards', function (Blueprint $table) {
            $table->dropForeign(['contest_id']);
        });

        Schema::drop('contest_rewards');
    }
}
