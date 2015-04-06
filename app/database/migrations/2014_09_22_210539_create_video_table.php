<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function($table){
			$table->increments('id');
			$table->morphs('viewable');
			$table->integer('language_id')->unsigned();
			$table->integer('video_number')->unsigned()->default(0); // Denotes the number in the video sequence.
			$table->string('path')->nullable();
			$table->string('timestamps_json')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('videos');
	}

}
