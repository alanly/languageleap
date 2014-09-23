<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shows', function($table){
			$table->increments('id');
			$table->string('name');
			$table->string('description');
			$table->string('image_path');
			$table->string('director');
			$table->string('actor');
			$table->string('genre');			


		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shows');
	}

}
