<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewingHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('viewing_history', function($table){
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('video_id')->unsigned();
			$table->boolean('is_finished');
			$table->integer('current_time');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('viewing_history');
	}

}
