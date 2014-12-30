<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('episodes', function($table){
			$table->increments('id');
			$table->integer('season_id')->unsigned();
			$table->integer('number');
			$table->string('name')->nullable();
			$table->string('description')->nullable();
			$table->integer('level_id')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('episodes');
	}

}
