<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendSettingsColumnToPagesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page__pages', function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->text('settings')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page__pages', function (Blueprint $table) {
            $table->string('icon', 100)->nullable();
            $table->dropColumn('settings');
        });
    }
}
