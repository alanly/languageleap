<?php 

use LangLeap\TestCase;

/**
 * @author Thomas Rahn <Thomas@rahn.ca>
 */
class ApiUserPanelControllerTest extends TestCase {

	/**
	 * Test geting Users level.
	 *
	 * @return void
	 */
	public function testShowLevel()
	{
		$this->seed();
		$this->be($this->createUser());

		$response = $this->action('GET', 'ApiUserPanelController@showLevel');
		$this->assertResponseOk();		
		$this->assertViewHas('level');
	}

	/**
	 * Test geting Users information.
	 *
	 * @return void
	 */
	public function testShowInfo()
	{
		$this->seed();
		$this->be($this->createUser());

		$response = $this->action('GET', 'ApiUserPanelController@showInfo');
		$this->assertResponseOk();		
		$this->assertViewHas('langs');
		$this->assertViewHas('data');
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

		$this->seed('LanguageTableSeeder');

		return $user->create([
			'username'		=> $username,
			'password'		=> Hash::make($password),
			'email'			=> $email,
			'first_name'	=> 'John',
			'last_name'		=> 'Smith',
			'language_id'	=> 1,
			'level_id'		=> 1,
			'is_admin'		=> $isAdmin,
			'is_confirmed'	=> true,
		]);
	}
}