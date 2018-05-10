<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUriColumnToPagePageTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('page__page_translations', 'uri')) {
            Schema::table('page__page_translations', function (Blueprint $table) {
                $table->dropColumn('uri');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(!Schema::hasColumn('page__page_translations', 'uri')) {
            Schema::table('page__page_translations', function (Blueprint $table) {
                $table->string('uri')->nullable();
            });
        }
    }
}
