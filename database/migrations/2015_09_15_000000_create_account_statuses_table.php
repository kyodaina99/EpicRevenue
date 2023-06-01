<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->enum('any_network_added', ['yes', 'no'])->default('no');
            $table->enum('is_contact_info_added', ['yes', 'no'])->default('no');
            $table->enum('any_payment_method_added', ['yes', 'no'])->default('no');
            $table->enum('email_confirmed', ['yes', 'no'])->default('no');
            $table->timestamp('email_confirm_send_at')->nullable()->default(null);
            $table->string('email_confirm_code')->nullable();
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
        Schema::table('account_statuses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::drop('account_statuses');
    }
}
