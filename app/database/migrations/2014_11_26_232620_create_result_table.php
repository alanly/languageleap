<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('results', function($table){
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('videoquestion_id')->unsigned();
			$table->boolean('is_correct');
			$table->timestamp('timestamp');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('results');
	}

}
