<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSitemapColumnsToPagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page__pages', function(Blueprint $table)
        {
            $table->boolean('sitemap_include')->default(1);
            $table->enum('sitemap_priority', ['0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0'])->default('0.9');
            $table->enum('sitemap_frequency', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'])->default('weekly');
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
            $table->dropColumn([
               'sitemap_priority', 'sitemap_frequency', 'sitemap_include'
            ]);
        });
    }

}
