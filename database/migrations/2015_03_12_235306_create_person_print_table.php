<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonPrintTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('person_prints', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('entry');

			$table->decimal('year', 5, 1)->nullable()->default(null);

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
		Schema::drop('person_prints');
	}

}
