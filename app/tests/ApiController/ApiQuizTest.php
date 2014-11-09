<?php

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;

class ApiQuizControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}

	/**
	*	This method will test the index method of the ApiQuizController.
	*
	*/
	public function testIndex(){
		$video = Video::first();

		$definition = Definition::all();
		$all_words = array();
		$selected_words = array();

		foreach ($definition as $def) {
			array_push($all_words, $def->id);
		}
		array_push($selected_words, $all_words[0]);

		$response = $this->action(
			'get',
			'ApiQuizController@index',
			[],["video_id"=>$video->id, "all_words" => $all_words, "selected_words" => $selected_words]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('quiz', $data);
		$this->assertObjectHasAttribute('question', $data);
		$this->assertObjectHasAttribute('question_id', $data);
		$this->assertObjectHasAttribute('definitions', $data);
	}

	/**
	*	This test will test if a proper error code is recieved when trying to get a quiz with no/invalid deinitions
	*
	*/
	public function testIndexWithNoDefinitions(){
		$video = Video::first();

		$definition = Definition::all();
		$all_words = array();
		$selected_words = array();

		$response = $this->action(
			'get',
			'ApiQuizController@index',
			[],["video_id"=>$video->id, "all_words" => $all_words, "selected_words" => $selected_words]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	/**
	*	This test will test that a proper error code is recieved when trying to get a quiz with an invalid video
	*
	*/
	public function testIndexWithInvalidVideo(){

		$definition = Definition::all();
		$all_words = array();
		$selected_words = array();

		$response = $this->action(
			'get',
			'ApiQuizController@index',
			[],["video_id"=>-1, "all_words" => $all_words, "selected_words" => $selected_words]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	
}
