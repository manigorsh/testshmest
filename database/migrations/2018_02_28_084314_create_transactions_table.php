<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->decimal('amount', 8, 2)->default(0);
            $table->decimal('balance', 8, 2)->default(0);

            $table->enum('type', [
                'deposit', 'withdraw', 'initial',
                'knb_bet', 'knb_win', 'knb_loose', 'knb_draw', 'knb_partner_reward', 'knb_system_commission', 'knb_referrer_commission'
            ]);

            $table->text('description', 64)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
