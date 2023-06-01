<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->index();
            $table->date('date');
            $table->integer('clicks');
            $table->integer('leads');
            $table->decimal('cr', 4);
            $table->decimal('revenue', 4);
            $table->decimal('profit', 4);
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
        Schema::drop('campaign_stats');
    }
}
