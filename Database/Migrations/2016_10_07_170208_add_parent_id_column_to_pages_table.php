<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentIdColumnToPagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page__pages', function(Blueprint $table)
        {
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('page__pages')->onDelete('cascade');
            $table->integer('position')->unsigned()->default(0);
            $table->boolean('is_root')->default(0);
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
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'position', 'is_root']);
        });
    }

}
