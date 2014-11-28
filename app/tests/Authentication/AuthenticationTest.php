<?php 

use LangLeap\Accounts\User;
use LangLeap\TestCase;

/**
*
*	@author Thomas Rahn <Thomas@rahn.ca>
*
*/
class AuthenticationTest extends TestCase {

	/**
	 * Setup the authentication test run by seeding the database and starting
	 * the session.
	 *
	 * @return  void
	 */
	public function setUp()
	{
		parent::setUp();
		Session::start();
		$this->seed('UserTableSeeder');
	}

	/**
	 * Test retrieving the login form.
	 *
	 */
	public function testGetLoginForm()
	{
		$this->call('GET', 'auth/login');

		$this->assertResponseOk();
	}

	/**
	 * Test valid authentication attempt.
	 *
	 */
	public function testPostLoginWithValidCredentials()
	{
		$response = $this->call(
			'POST',
			'auth/login',
			array(
				'username' => 'testUser123',
				'password' => 'password123',
				'_token' => csrf_token(),
				)
			);
		$this->assertTrue(Auth::check());
	}

	/**
	 * Test invalid authentication attempt where the user username does not
	 * exist.
	 *
	 */
	public function testPostLoginWithInvalidEmail()
	{
		$response = $this->call(
			'POST',
			'auth/login',
			array(
				'username' => 'fakeuser',
				'password' => 'admin',
				'_token' => csrf_token(),
				)
			);
		$this->assertFalse(Auth::check());
		$this->assertRedirectedToRoute('login');
	}

	/**
	 * Test invalid authentication attempt where the user password does not
	 * properly match, but the username is correct.
	 *
	 */
	public function testPostLoginWithInvalidPassword()
	{
		$response = $this->call(
			'POST',
			'auth/login',
			array(
				'username' => 'testUser123',
				'password' => 'abc123',
				'_token' => csrf_token(),
				)
			);
		$this->assertFalse(Auth::check());
		$this->assertRedirectedToRoute('login');
	}

}