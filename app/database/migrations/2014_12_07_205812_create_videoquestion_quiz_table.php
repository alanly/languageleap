<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideoQuestionQuizTable extends Migration {

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

			$table->foreign('videoquestion_id')
			      ->references('id')->on('videoquestions')
			      ->onDelete('cascade');
			$table->foreign('quiz_id')
			      ->references('id')->on('quizzes')
			      ->onDelete('cascade');
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
