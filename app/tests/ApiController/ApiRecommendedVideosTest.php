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

		$response = $this->action('GET', 'ApiRecommendedVideosController@index');

		$this->assertResponseOk();
	}
}
