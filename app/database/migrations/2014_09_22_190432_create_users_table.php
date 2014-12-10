<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table){
			$table->increments('id');
			$table->string('username');
			$table->string('email');
			$table->string('password');
			$table->string('first_name');
			$table->string('last_name');
			$table->boolean('is_admin')->default(0);
			$table->boolean('is_confirmed')->default(0);
			$table->string('confirmation_code')->nullable();
			$table->rememberToken();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}

}
