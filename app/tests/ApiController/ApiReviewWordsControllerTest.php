<?php

use LangLeap\TestCase;
use LangLeap\Words\WordBank;

class ApiReviewWordsControllerTest extends TestCase {

	public function testIndex()
	{
		$this->seed();
		
		$response = $this->action('GET', 'ApiReviewWordsController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
}