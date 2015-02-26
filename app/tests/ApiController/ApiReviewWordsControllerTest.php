<?php

use LangLeap\TestCase;
use LangLeap\Words\WordBank;
use LangLeap\Accounts\User;

class ApiReviewWordsControllerTest extends TestCase {

	public function testIndex()
	{
		$this->seed();
		$this->be(User::first());

		$response = $this->action('GET', 'ApiReviewWordsController@getIndex');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
}