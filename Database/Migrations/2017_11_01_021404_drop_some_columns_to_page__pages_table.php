<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSomeColumnsToPagePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('page__pages', 'icon')) {
            Schema::table('page__pages', function (Blueprint $table) {
                $table->dropColumn('icon');
            });
        }
        if(Schema::hasColumn('page__pages', 'video')) {
            Schema::table('page__pages', function (Blueprint $table) {
                $table->dropColumn('video');
            });
        }
        if(Schema::hasColumn('page__page_translations', 'sub_title')) {
            Schema::table('page__page_translations', function (Blueprint $table) {
                $table->dropColumn('sub_title');
            });
        }
    }
}
