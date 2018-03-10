<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterKnbGameRenameMd5SaltToMd5Text extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `knb_games` CHANGE `md5_salt` `md5_text` VARCHAR(255);"); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `knb_games` CHANGE `md5_text` `md5_salt` VARCHAR(255);"); 
    }
}
