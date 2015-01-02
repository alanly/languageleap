<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuestionQuizTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('question_quiz');
		Schema::create('videoquestion_quiz', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('videoquestion_id')->unsigned();
			$table->foreign('videoquestion_id')->references('id')
				->on('videoquestions')->onDelete('cascade');
			$table->integer('quiz_id')->unsigned();
			$table->foreign('quiz_id')->references('id')
				->on('quizzes')->onDelete('cascade');
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
		Schema::create('question_quiz', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('question_id')->unsigned()->index();
			$table->foreign('question_id')->references('id')
				->on('questions')->onDelete('cascade');
			$table->integer('quiz_id')->unsigned()->index();
			$table->foreign('quiz_id')->references('id')
				->on('quizzes')->onDelete('cascade');
			$table->timestamps();
		});
	}

}
