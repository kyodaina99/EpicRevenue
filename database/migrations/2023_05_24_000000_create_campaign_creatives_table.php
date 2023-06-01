<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignCreativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_creatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('creative_id'); //basically upload id
            $table->unsignedBigInteger('user_id')->default(0); // if set only this user can see the creative
            $table->unsignedTinyInteger('status')->default(0); // 0 = Active,1 = Paused
            $table->string('caption')->nullable();
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
        Schema::dropIfExists('campaign_creatives');
    }
}
