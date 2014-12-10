<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;

/**
 * @author Michael Lavoie <lavoie6453@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class RegistrationControllerTest extends TestCase {

	protected function createUserData()
	{
		return $userData = [
			'username'   => 'testUser123',
			'email'      =>'test@tester.com',
			'first_name' => 'John',
			'last_name'  =>'Doe',
			'password'   => 'password123',
			'password_confirmation' => 'password123'
		];
	}

	public function setUp()
	{
		parent::setUp();

		Route::enableFilters();
	}

	public function testCreatingANewUser()
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
		$this->assertContains(
			'You have successfully registered! A confirmation email has been sent.',
			$response->getContent()
		);
	}

	public function testFailsWhenCreatingADuplicateUser()
	{
		$userData = $this->createUserData();

		// Create the user first
		$response = $this->action('POST', 'RegistrationController@postIndex', [], $userData);

		// Attempt to create the user again
		$response = $this->action('POST', 'RegistrationController@postIndex', [], $userData);

		// Should return errors
		$this->assertRedirectedToAction('RegistrationController@getIndex');
		$this->assertSessionHasErrors();
	}

	public function testFailsWhenCreatingAUserWhileAuthenticated()
	{
		$userData = $this->createUserData();

		// Authenticate as a user.
		$this->be(new User());

		$response = $this->action('POST', 'RegistrationController@postIndex', [], $userData);

		$this->assertRedirectedTo('/');
		$this->assertSessionHas('action.failed', true);
	}

	public function testConfirmingANewUser()
	{
		$userData = $this->createUserData();

		$response = $this->action('POST', 'RegistrationController@postIndex', [], $userData);

		// Verify the created user's details.
		$user = User::where('username', $userData['username'])->first();

		$response = $this->action('GET', 'RegistrationController@getVerify', [$user->confirmation_code]);

		// Retrieve the confirmed user's details
		$user = User::where('username', $userData['username'])->first();

		$this->assertSame($user->is_confirmed, '1');
		$this->assertContains(
			'You have successfully verified your account! Please login.',
			$response->getContent()
		);
	}

	public function testFailsConfirmingANonExistingUser()
	{
		$userData = $this->createUserData();

		$response = $this->action('GET', 'RegistrationController@getVerify', ['0000']);

		// Check that the client is redirected to the registration page
		$this->assertRedirectedToAction('RegistrationController@getIndex');
	}
	
}
