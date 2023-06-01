<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create support_tickets table
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->default(1);
            $table->integer('status')->nullable()->default(0); // 0 = Pending Support Response, 1 = Pending User Response, 2 = Close
            $table->string('subject');
            $table->text('message');
            $table->timestamps();
        });

        // Create support_ticket_categories table
        Schema::create('support_ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
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
        Schema::dropIfExists('support_tickets,support_ticket_categories');
    }
}
