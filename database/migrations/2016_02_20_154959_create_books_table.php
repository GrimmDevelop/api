<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('short_title')->nullable()->default(null);

            $table->integer('volume')->nullable()->default(null);
            $table->integer('volume_irregular')->nullable()->default(null);
            $table->string('edition')->nullable()->default(null);

            $table->integer('year')->nullable()->default(null);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
