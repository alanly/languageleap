<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatVideoquestionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('videoquestions', function($table)
		{
			$table->dropColumn(array('video_id'));
			
		});
		
		Schema::table('videoquestions', function($table)
		{
			$table->integer('quiz_id')->unsigned()->default(-1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('videoquestions', function($table)
		{
			$table->integer('video_id')->unsigned();
		});
		
		Schema::table('videoquestions', function($table)
		{
			$table->dropColumn('quiz_id');
		});
	}

}
