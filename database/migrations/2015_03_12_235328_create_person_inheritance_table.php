<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonInheritanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('person_inheritances', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('entry');

			$table->integer('person_id')->unsigned();

			$table->timestamps();
			$table->softDeletes();

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
		Schema::drop('person_inheritances');
	}

}
