<?php 

use LangLeap\TestCase;

/**
 * @author Thomas Rahn <Thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
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
	}


	public function testFetchingTheLoginViewAsGuest()
	{
		Route::enableFilters();

		$this->action('GET', 'AuthController@getLogin');
		$this->assertResponseOk();
	}


	public function testFetchingTheLoginViewAsAuthenticatedUser()
	{
		Route::enableFilters();

		$this->be($this->createUser());
		$this->action('GET', 'AuthController@getLogin');
		$this->assertRedirectedTo('/');
	}


	public function testSuccessWhenAuthenticatingAsAUser()
	{
		$this->createUser();

		$response = $this->action(
			'POST',
			'AuthController@postLogin',
			[],
			[
				'username' => 'user',
				'password' => 'password',
			]
		);

		$this->assertRedirectedTo('/');
		$this->assertSessionHas('action.failed', false);
		$this->assertTrue(Auth::check());
	}


	public function testFailsWhenAuthenticatingWithWrongUsername()
	{
		$this->createUser();

		$response = $this->action(
			'POST',
			'AuthController@postLogin',
			[],
			[
				'username' => 'wronguser',
				'password' => 'password',
			]
		);

		$this->assertRedirectedToAction('AuthController@getLogin');
		$this->assertSessionHas('action.failed', true);
		$this->assertFalse(Auth::check());
	}


	public function testFailsWhenAuthenticatingWithWrongPassword()
	{
		$this->createUser();

		$response = $this->action(
			'POST',
			'AuthController@postLogin',
			[],
			[
				'username' => 'user',
				'password' => 'badpassword',
			]
		);

		$this->assertRedirectedToAction('AuthController@getLogin');
		$this->assertSessionHas('action.failed', true);
		$this->assertFalse(Auth::check());
	}


	public function testSuccessWhenLoggingOutAsAnAuthenticatedUser()
	{
		$this->be($this->createUser());

		$this->action('GET', 'AuthController@getLogout');

		$this->assertRedirectedToAction('AuthController@getLogin');
		$this->assertSessionHas('action.failed', false);
		$this->assertFalse(Auth::check());
	}


	public function testRedirectsWhenTryingToLogoutAsAGuest()
	{
		Route::enableFilters();

		$this->action('GET', 'AuthController@getLogout');
		$this->assertRedirectedToAction('AuthController@getLogin');
	}


	protected function makeUserInstance()
	{
		return App::make('LangLeap\Accounts\User');
	}


	protected function createUser(
		$username = 'user',
		$password = 'password',
		$email    = 'admin@test.com',
		$isAdmin  = false
	)
	{
		$user = $this->makeUserInstance();

		return $user->create([
			'username'   => $username,
			'password'   => Hash::make($password),
			'email'      => $email,
			'first_name' => 'John',
			'last_name'  => 'Smith',
			'is_admin'   => $isAdmin,
		]);
	}

}