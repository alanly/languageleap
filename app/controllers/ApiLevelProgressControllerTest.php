<?php

use LangLeap\TestCase;

class ApiLevelProgressControllerTest extends TestCase {

	public function testPostIndex()
	{
		$this->seed();
		$this->be(User::first());

		$response = $this->action('POST', 'ApiLevelProgressController@postIndex');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
	
	public function testGetIndex()
	{
		$this->seed();
		$this->be(User::first());
		
		$response = $this->action('GET', 'ApiLevelProgressController@getIndex');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
}