<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;

class ApiRecommendedVideosControllerTest extends TestCase {

	public function testFailOnNotAuthenticated()
	{
		$response = $this->action('GET', 'ApiRecommendedVideosController@index');

		$this->assertResponseStatus(401);
	}

	public function testSuccessOnAuthenticated()
	{
		// Authenticate a user
		$this->be(new User());

		// Mock the Redis client.
		$rc = Mockery::mock();
		$rc->shouldReceive('zcard');
		$rc->shouldReceive('pipeline');
		$rc->shouldReceive('zrange');

		$rf = Mockery::mock('Illuminate\Redis\Database');
		$rf->shouldReceive('connection')->once()->andReturn($rc);

		App::instance('Illuminate\Redis\Database', $rf);

		$response = $this->action('GET', 'ApiRecommendedVideosController@index');

		$this->assertResponseOk();
	}
}
