<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movies', function($table){
			$table->increments('id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->string('director')->nullable();
			$table->string('actor')->nullable();
			$table->string('genre')->nullable();
			$table->integer('level_id')->unsigned()->default(1);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('movies');
	}

}
