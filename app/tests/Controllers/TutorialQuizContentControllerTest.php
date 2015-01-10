<?php

use LangLeap\TestCase;

class TutorialQuizContentControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
		$this->seed();
	}
	
	public function testIndex()
	{
		$response = $this->action('GET', 'TutorialQuizContentController@getIndex', [0]);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		
		$data = $response->getData()->data;
		
		$this->assertCount(5, $data[0]);		// 5 questions
		$this->assertCount(20, $data[1]);	// 20 answers
	}
}