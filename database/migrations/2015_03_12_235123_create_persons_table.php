<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {

            $table->increments('id');

            $table->string('last_name');
            $table->string('first_name')->nullable();

            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->string('bio_data')->nullable();
            $table->string('bio_data_source')->nullable();
            $table->string('add_bio_data')->nullable();
            $table->boolean('is_organization')->default(false);

            $table->boolean('auto_generated')->default(false);

            $table->string('source');

            $table->timestamps();
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
        Schema::drop('persons');
    }

}
