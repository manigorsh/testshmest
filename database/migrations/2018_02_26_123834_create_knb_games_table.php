<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKnbGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knb_games', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->string('md5_hash')->nullable();
            $table->string('md5_salt')->nullable();
            $table->softDeletes();

            $table->decimal('bet', 8, 2)->default(100);
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users');

            $table->integer('opponent_id')->nullable()->unsigned();
            $table->foreign('opponent_id')->references('id')->on('users');

            $table->enum('creator_hand', ['rock', 'scissors', 'paper']);
            $table->enum('opponent_hand', ['rock', 'scissors', 'paper'])->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('knb_games');
    }
}
