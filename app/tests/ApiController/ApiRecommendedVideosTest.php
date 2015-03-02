<?php

use LangLeap\TestCase;
use LangLeap\Videos\Episode;
use LangLeap\Accounts\User;
use LangLeap\Videos\RecommendationSystem\Recommendation;

class ApiRecommendedVideosControllerTest extends TestCase {

	public function testFailOnNotAuthenticated()
	{
		$response = $this->action('GET', 'ApiRecommendedVideosController@index');

		$this->assertResponseStatus(401);
	}

	public function testSuccessOnAuthenticated()
	{
		$this->seed();

		$user = User::first();
		
		// Authenticate a user
		$this->be($user);

		$recommendation = new Recommendation(Episode::first(), 5);
		$tore = Mockery::mock('LangLeap\Videos\RecommendationSystem\Recommendatore');
		App::instance('LangLeap\Videos\RecommendationSystem\Recommendatore', $tore);
		$tore->shouldReceive('generate')->once();
		$tore->shouldReceive('fetch')->once()->andReturn([$recommendation]);

		$response = $this->action('GET', 'ApiRecommendedVideosController@index');

		$this->assertResponseOk();
	}
}
