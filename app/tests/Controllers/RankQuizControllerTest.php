<?php

use LangLeap\TestCase;
use LangLeap\Levels\Level;

/**
 * @author KC Wan
 * @author Alan Ly <hello@alan.ly>
 */
class RankQuizTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		$this->seed();
	}


	public function testRetrievingTheQuizAsAnUnauthenticatedUserFails()
	{
		Route::enableFilters();

		$response = $this->action('GET', 'RankQuizController@getIndex');

		$this->assertRedirectedTo('/login');
		$this->assertSessionHas('action.failed', true);
	}


	public function testRetrievingTheQuizAsAnAuthenticatedButRankedUserFails()
	{
		Route::enableFilters();

		$user = new LangLeap\Accounts\User;
		$user->level_id = 20;
		$this->be($user);

		$response = $this->action('GET', 'RankQuizController@getIndex');

		$this->assertRedirectedTo('/');
	}


	public function testRetrievingTheQuizAsAnAuthenticatedAndUnrankedUserWorks()
	{
		Route::enableFilters();

		$user = new LangLeap\Accounts\User;
		$user->level_id = Level::where('code', 'ur')->first()->id;
		$this->be($user);

		$response = $this->action('GET', 'RankQuizController@getIndex');

		$this->assertResponseOk();
	}
	
}
