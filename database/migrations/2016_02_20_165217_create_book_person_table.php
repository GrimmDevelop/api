<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookPersonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_person', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('book_id')->unsigned();
			$table->integer('person_id')->unsigned();

			$table->integer('page')->default(null);
			$table->integer('page_to')->default(null);
			$table->string('page_description')->default(null);
			$table->integer('line')->default(null);

			$table->timestamps();

			$table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
			$table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');

			$table->unique(['book_id', 'person_id', 'page', 'line']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_person');
	}

}
