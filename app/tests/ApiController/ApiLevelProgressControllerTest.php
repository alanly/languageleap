<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;

class ApiLevelProgressControllerTest extends TestCase {

	public function testIncreasedTotalPoints()
	{
		$this->seed();
		
		$user = User::first();
		$this->be($user);
		
		$score = 100;
		
		$initialPoints = $user->total_points;
		
		$response = $this->action('POST', 'ApiLevelProgressController@postIndex', [], ['score' => $score]);
		$user = User::find($user->id);
		
		$this->assertNotSame($initialPoints, $user->total_points);
		
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
	
	public function testIncreasedLevel()
	{
		$this->seed();
		
		$user = User::first();
		$this->be($user);
		
		$score = 100;
		
		$initialLevel = $user->level_id;
		
		$response = $this->action('POST', 'ApiLevelProgressController@postIndex', [], ['score' => $score]);
		$user = User::find($user->id);
		
		$this->assertNotSame($initialLevel, $user->level_id);
		
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
	
	public function testSameLevel()
	{
		$this->seed();
		
		$user = User::first();
		$this->be($user);
		
		$score = 0;
		
		$initialLevel = $user->level_id;
		
		$response = $this->action('POST', 'ApiLevelProgressController@postIndex', [], ['score' => $score]);
		$user = User::find($user->id);
		
		$this->assertEquals($initialLevel, $user->level_id);
		
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
	
	public function testGetIndex()
	{
		$this->seed();
		
		$user = User::first();
		$this->be($user);
		
		$userLevel = $user->level_id
		;
		$response = $this->action('GET', 'ApiLevelProgressController@getIndex');

		$this->assertEquals($userLevel, $response->getData()->data->level_id);
		
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
}