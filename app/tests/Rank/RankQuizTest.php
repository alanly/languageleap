<?php

use LangLeap\TestCase;
use LangLeap\DictionaryUtilities\EnglishDictionary;
use LangLeap\Core\Language;

class RankQuizTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->seed();
	}

	public function testGetRankQuizUserFirstTime()
	{
		$this->be($this->createUser(1));
		$response = $this->action('GET', 'RankQuizController@getIndex');

		$this->assertInstanceOf('Illuminate\Http\Response', $response);
		$this->assertResponseOk();
	}

	public function testGetRankQuizUserNotFirstTime()
	{
		$this->be($this->createUser(0));
		$response = $this->action('GET', 'RankQuizController@getIndex');

		$this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
		$this->assertResponseStatus(302);
	}

	public function testGetRankQuizUserInvalid()
	{
		$response = $this->action('GET', 'RankQuizController@getIndex');

		$this->assertInstanceOf('Illuminate\Http\Response', $response);
		$this->assertResponseStatus(403);
	}
	
	public function testSkipRankUnranked()
	{
		$this->be($this->createUser(1));
		$response = $this->action('GET', 'RankQuizController@skipRanking');

		$this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
		$this->assertResponseStatus(302);
	}
	
	public function testSkipRankAlreadyRanked()
	{
		$this->be($this->createUser(2));
		$response = $this->action('GET', 'RankQuizController@skipRanking');

		$this->assertInstanceOf('Illuminate\Http\Response', $response);
		$this->assertResponseStatus(400);
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
