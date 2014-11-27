<?php

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
		$user->create(array('username' => 'testUser123',
							'email'=>'test@tester.com',
							'first_name' => 'John',
							'last_name'=>'Doe',
							'password' => 'password123'));
	}
}