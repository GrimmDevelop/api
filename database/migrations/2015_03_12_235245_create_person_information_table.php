<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonInformationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('person_information', function(Blueprint $table)
		{
			$table->increments('id');

			$table->text('data');

			$table->integer('person_code_id')->unsigned();
			$table->integer('person_id')->unsigned();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('person_code_id')->references('id')->on('person_codes')->onDelete('cascade');
			$table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('person_information');
	}

}
