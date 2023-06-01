<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_targets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned();
            $table->integer('rate');
            $table->integer('network_rate')->nullable()->default(null);
            $table->enum('active', ['yes', 'no'])->default('no');
            $table->enum('device', ['Mobile', 'Tablet', 'Desktop'])->default('Desktop');
            $table->string('operating_system')->nullable();
            $table->string('country')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();

            $table->foreign('campaign_id')
                ->references('id')->on('campaigns')
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
        Schema::table('campaign_targets', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
        });
        Schema::drop('campaign_targets');
    }
}
