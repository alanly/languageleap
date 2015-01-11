<?php

use LangLeap\Core\Language;
use LangLeap\Levels\Level;
class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::table('users')->delete();

		$user = App::make('LangLeap\Accounts\User');
		$lang = Language::first();
		$level = Level::first();

		$user->create([
			'username'		=> 'administrator',
			'password'		=> Hash::make('password'),
			'email'			=> 'admin@test.com',
			'first_name'	=> 'John',
			'last_name'		=> 'Smith',
			'language_id'	=> $lang->id,
			'level_id'		=> $level->id,
			'is_admin'		=> true,
			'is_confirmed'	=> true
		]);

		$user->create([
			'username'		=> 'user',
			'password'		=> Hash::make('password'),
			'email'			=> 'user@test.com',
			'first_name'	=> 'Jane',
			'last_name'		=> 'Smith',
			'language_id'	=> $lang->id,
			'level_id'		=> $level->id,
			'is_admin'		=> false,
			'is_confirmed'	=> true
		]);
	}

}
