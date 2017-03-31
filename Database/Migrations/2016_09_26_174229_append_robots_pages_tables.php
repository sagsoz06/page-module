<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendRobotsPagesTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page__pages', function(Blueprint $table)
        {
            $table->enum('meta_robot_no_index', ['index', 'noindex'])->default('index');
            $table->enum('meta_robot_no_follow', ['follow', 'nofollow'])->default('follow');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page__pages', function(Blueprint $table)
        {
            $table->dropColumn('meta_robot_no_index');
            $table->dropColumn('meta_robot_no_follow');
        });
    }

}
