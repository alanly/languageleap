<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideoquestionQuizTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videoquestion_quiz', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('videoquestion_id')->unsigned();
			$table->integer('quiz_id')->unsigned();
			$table->boolean('is_correct')->default(false);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('videoquestion_quiz');
	}

}
