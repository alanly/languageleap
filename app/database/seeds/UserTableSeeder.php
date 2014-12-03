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
							'is_admin' => false,
							'password' => Hash::make('password123')));
		$user->create(array('username' => 'admin@local.ca',
							'email'=>'admin@langleap.ca',
							'first_name' => 'John',
							'last_name'=>'Doe',
							'is_admin' => true,
							'password' => Hash::make('Admin123')));
	}
}