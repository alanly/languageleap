<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quizzes', function($table){
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('video_id')->unsigned()->nullable();
			$table->float('score')->default(0);	
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('quizzes');
	}

}
