<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;

class ApiLevelProgressControllerTest extends TestCase {

	public function testIncreasedTotalPointsPostIndex()
	{
		$this->seed();
		
		$user = User::first();
		$this->be($user);
		
		$initialPoints = $user->total_points;
		$response = $this->action('POST', 'ApiLevelProgressController@postIndex');
		
		$newUser = Auth::user();
		
		$this->assertNotEquals($initialPoints, $newUser->totalpoints);
		
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
	
	public function testIncreasedLevelPostIndex()
	{
		$this->seed();
		
		$user = User::first();
		$this->be($user);
		
		$initialLevel = $user->level_id;
		$response = $this->action('POST', 'ApiLevelProgressController@postIndex');
		
		$newUser = Auth::user();
		$this->assertNotEquals($initialLevel, $newUser->level);
		
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
	
	public function testGetIndex()
	{
		$this->seed();
		
		$user = User::first();
		$this->be($user);
		
		$userLevel = $user->level_id;		
		$response = $this->action('GET', 'ApiLevelProgressController@getIndex');
		
		$newUser = Auth::user();
		$this->assertEquals($userLevel, $newUser->level_id);
		
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
}