<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordBankTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('word_bank', function($table){
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('definition_id')->unsigned();
			$table->morphs('media');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('word_bank');
	}

}
