<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendSomeColumnsToPageTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page__pages', function (Blueprint $table) {
            $table->string('icon', 100)->nullable();
            $table->string('video', 100)->nullable();
        });
        Schema::table('page__page_translations', function (Blueprint $table) {
            $table->string('sub_title')->nullable();
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
            $table->dropColumn(['icon','video']);
        });
        Schema::table('page__page_translations', function (Blueprint $table) {
            $table->dropColumn('sub_title');
        });
    }
}
