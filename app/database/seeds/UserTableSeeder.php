<?php

use LangLeap\Core\Language;

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

		$user->create([
			'username'      => 'administrator',
			'password'      => Hash::make('password'),
			'email'         => 'admin@test.com',
			'first_name'    => 'John',
			'last_name'     => 'Smith',
			'language_id'   => $lang->id,
			'is_admin'      => true,
			'is_confirmed'	=> true
		]);

		$user->create([
			'username'      => 'user',
			'password'      => Hash::make('password'),
			'email'         => 'user@test.com',
			'first_name'    => 'Jane',
			'last_name'     => 'Smith',
			'language_id'   => $lang->id,
			'is_admin'      => false,
			'is_confirmed'	=> true
		]);
	}

}
