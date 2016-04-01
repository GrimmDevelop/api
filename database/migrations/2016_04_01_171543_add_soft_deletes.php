<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('person_codes', function(Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('book_person', function(Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('person_codes', function(Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('book_person', function(Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
