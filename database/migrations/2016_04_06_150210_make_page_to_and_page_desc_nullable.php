<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePageToAndPageDescNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_person', function (Blueprint $table) {
            $table->integer('page_to')->nullable()->default(null)->change();
            $table->string('page_description')->nullable()->default(null)->change();
            $table->integer('line')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_person', function (Blueprint $table) {
            $table->integer('page_to')->change();
            $table->string('page_description')->change();
            $table->integer('line')->change();
        });
    }
}
