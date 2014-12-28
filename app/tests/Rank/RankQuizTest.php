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

	public function testGetRankQuizUserFirstTime()
	{
		$this->be($this->createUser(0));
		$response = $this->action('GET', 'RankController@getIndex', [], []);

		$this->assertInstanceOf('Illuminate\Http\Response', $response);
		$this->assertResponseOk();
	}

	public function testGetRankQuizUserNotFirstTime()
	{
		$this->be($this->createUser(1));
		$response = $this->action('GET', 'RankController@getIndex', [], []);

		$this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
		$this->assertResponseStatus(302);
	}

	public function testGetRankQuizUserInvalid()
	{
		$response = $this->action('GET', 'RankController@getIndex', [], []);

		$this->assertInstanceOf('Illuminate\Http\Response', $response);
		$this->assertResponseStatus(404);
	}


	public function testGetRankQuizResultValid()
	{
		$this->be($this->createUser(0));
		$response = $this->action('GET', 'RankController@getIndex', [], []);

		$this->assertInstanceOf('Illuminate\Http\Response', $response);
		$this->assertResponseOk();

		/*
		Assertions TODO
		1. User answered all questions
		2. User now has a 'level_id' which is NOT 0
		3. Correct view is returned with User's new level
		*/

	}

	public function testGetRankQuizResultInvalid()
	{
		$this->be($this->createUser(0));
		$response = $this->action('GET', 'RankController@getIndex', [], []);

		$this->assertInstanceOf('Illuminate\Http\Response', $response);
		$this->assertResponseOk();

		/*
		Assertions TODO
		1. User answered all questions --> This should fail
		2. Make sure that 'level_id' is still 0
		3. Correct view is returned with error message
		*/
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
