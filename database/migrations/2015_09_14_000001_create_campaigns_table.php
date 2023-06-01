<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('name');
            $table->longText('description');
            $table->longText('requirements');
            $table->string('url');
            $table->integer('rate_percentage')->default('30');
            $table->decimal('rate',14,2);
            $table->decimal('network_rate',14,2);
            $table->integer('network_rate_type')->default('0'); //0,1,2,3 = CPL/CPS/CPA/CPI, 4 = Percentage {10% of sale} , 5 = CPC (Cost per click)
            $table->integer('cap')->nullable();
            $table->integer('cap_daily');
            $table->string('cap_url')->nullable();
            $table->enum('active', ['yes', 'no'])->default('yes');
            $table->enum('private', ['yes', 'no'])->default('no');
            $table->enum('incent', ['yes', 'no'])->default('no');
            $table->enum('mobile', ['yes', 'no'])->default('no');
            $table->longText('tracking');
            $table->integer('category_id');
            $table->integer('network_id');
            $table->string('featured_img')->nullable();
            $table->string('creatives')->nullable();
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
        Schema::drop('campaigns');
    }
}
