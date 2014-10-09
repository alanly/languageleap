<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScriptWordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('script_words', function($table){
			$table->increments('id');
			$table->integer('script_id')->unsigned();
			$table->integer('word_id')->unsigned();
			$table->integer('position');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('script_words');
	}

}
