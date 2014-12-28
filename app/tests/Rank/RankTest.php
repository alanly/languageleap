<?php

use LangLeap\TestCase;
use LangLeap\DictionaryUtilities\EnglishDictionary;
use LangLeap\Core\Language;

class EnglishDictionaryTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->seed();
	}

	public function testGetRankUserFirstTime()
	{
		$this->be($this->createUser(0));
		$response = $this->action('GET', 'RankController@getIndex', [], []);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
	}

	public function testGetRankUserNotFirstTime()
	{
		$this->be($this->createUser(1));
		$response = $this->action('GET', 'RankController@getIndex', [], []);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		
	}

	public function testGetRankUserInvalid()
	{
		$response = $this->action('GET', 'RankController@getIndex', [], []);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	protected function createUser(
		$level_id,
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
			'language_id'=> Language::first()->id,
			'is_admin'   => $isAdmin,
			'level_id'	 => $level_id,
		]);
	}

	protected function makeUserInstance()
	{
		return App::make('LangLeap\Accounts\User');
	}
	
}
