<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoQuestionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videoquestion', function($table){
			
			$table->increments('id');
			$table->integer('video_id')->unsigned();
			$table->integer('question_id')->unsigned();
			$table->integer('quiz_id')->unsigned();
			$table->boolean('is_custom');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('videoquestion');
	}

}
