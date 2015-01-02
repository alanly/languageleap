<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateResultTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('results', function($table)
		{
			$table->dropColumn(array('user_id', 'attempt'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('results', function($table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('attempt')->unsigned();
		});
	}

}
