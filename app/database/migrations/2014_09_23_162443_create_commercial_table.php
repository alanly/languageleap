<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('commercials', function($table){
			$table->increments('id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->string('image_path')->nullable();
			$table->integer('level_id')->unsigned()->default(1);
			$table->boolean('is_published')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('commercials');
	}

}
