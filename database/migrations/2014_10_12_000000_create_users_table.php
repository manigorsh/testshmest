<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->integer('referrer_id')->default(1)->unsigned();
            $table->foreign('referrer_id')->references('id')->on('users');

        });

        DB::table('users')->insert(
            array(
                'email' => 'manigorsh@gmail.com',
                'name' => 'admin',
                'password' => Hash::make(env('ADMIN_INITIAL_PASSWORD', ''))
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
