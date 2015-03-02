<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;
use LangLeap\Core\Language;

class RegisterLoginTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}

	//1. Get register view
	//2. Register
	//3. Verify email address
	//4. Get login view
	//5. Login
	//6. Logout
	public function testRegisterAndLoginValidEmail()
	{
		$this->getRegisterView();
		$user = $this->getRegisteredUser();
		$confirmedUser = $this->confirmUserEmail($user);
		$this->getLoginView();
		$this->loginConfirmedEmail($user);
		$this->logout($user);
	}

	//1. Get register view
	//2. Register
	//4. Get login view
	//5. Login
	//6. Email not verified - get correct error message
	public function testRegisterAndLoginInvalidEmail()
	{
		$this->getRegisterView();
		$user = $this->getRegisteredUser();
		$this->getLoginView();
		$this->loginUnconfirmedEmail($user);
	}

	private function getRegisterView()
	{
		$this->action('GET', 'RegistrationController@getIndex');
		$this->assertResponseOk();
	}

	private function createUserData()
	{
		return $userData = [
			'username'  			=> 'testUser123',
			'email'      			=>'test@tester.com',
			'first_name' 			=> 'John',
			'last_name'				=>'Doe',
			'language_id'			=> Language::first()->id,
			'password'   			=> 'password123',
			'password_confirmation' => 'password123'
		];
	}

	public function getRegisteredUser()
	{
		$userData = $this->createUserData();

		$response = $this->action('POST', 'RegistrationController@postIndex', [], $userData);

		// Verify the created user's details.
		$user = User::where('username', $userData['username'])->first();

		$this->assertNotNull($user);
		$this->assertSame($userData['email'], $user->email);
		$this->assertSame($userData['first_name'], $user->first_name);
		$this->assertSame($userData['last_name'], $user->last_name);
		$this->assertTrue(Hash::check($userData['password'], $user->password));
		$this->assertSame($user->is_confirmed, '0');

		return $userData;
	}

	private function confirmUserEmail($user)
	{
		$u = User::where('username', $user['username'])->first();
		$u->is_confirmed = 1;
		$u->save();
	}

	private function getLoginView()
	{
		Route::enableFilters();

		$this->action('GET', 'AuthController@getLogin');
		$this->assertResponseOk();
	}

	private function loginConfirmedEmail($user)
	{
		$response = $this->action(
			'POST',
			'AuthController@postLogin',
			[],
			[
				'username' => $user['username'],
				'password' => $user['password'],
			]
		);

		$this->assertRedirectedTo('/');
		$this->assertSessionHas('action.failed', false);
		$this->assertTrue(Auth::check());
	}

	private function loginUnconfirmedEmail($user)
	{
		$response = $this->action(
			'POST',
			'AuthController@postLogin',
			[],
			[
				'username' => $user['username'],
				'password' => $user['password'],
			]
		);

		$this->assertRedirectedToAction('AuthController@getLogin');
		$this->assertSessionHas('action.failed', true);
		$this->assertFalse(Auth::check());
	}

	private function logout($user)
	{
		$u = User::where('username', $user['username'])->first();
		$this->be($u);

		$this->action('GET', 'AuthController@getLogout');

		$this->assertRedirectedToAction('AuthController@getLogin');
		$this->assertSessionHas('action.failed', false);
		$this->assertFalse(Auth::check());
	}
}
