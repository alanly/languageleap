<?php

use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\Result;
use LangLeap\Accounts\User;

class ApiQuizControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database and login
		$this->seed();
		$this->be(User::first());
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
			'post',
			'ApiQuizController@postIndex',
			[],["video_id" => $video->id, "all_words" => $all_words, "selected_words" => $selected_words]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('result_id', $data);
		$this->assertObjectHasAttribute('question', $data);

		$question = $data->question;
		$this->assertObjectHasAttribute('id', $question);
		$this->assertObjectHasAttribute('question', $question);
		$this->assertObjectHasAttribute('answer_id', $question);
		$this->assertObjectHasAttribute('last', $question);
		$this->assertObjectHasAttribute('answers', $question);
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
			'post',
			'ApiQuizController@postIndex',
			[],["video_id"=>$video->id, "all_words" => $all_words, "selected_words" => $selected_words]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$this->assertObjectHasAttribute('result', json_decode($response->getContent())->data);
		$this->assertObjectHasAttribute('redirect', json_decode($response->getContent())->data->result);
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
			'post',
			'ApiQuizController@postIndex',
			[],["video_id"=>-1, "all_words" => $all_words, "selected_words" => $selected_words]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	/**
	*	This test verifies that an 404 error will be returned when trying to answer a question that does not exist.
	*	404 == Not found
	*
	*/
	public function testQuizUpdateWithInvalidQuestion(){
		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],['question_id' => 0]
		);
		
		$this->assertResponseStatus(404);	
	}
	
	/**
	*	This test will verify that a 400 error will be returned when trying to answer with no selected id.
	*	400 == Bad Request
	*
	*/
	public function testQuizUpdateWithNoAnswer(){
		$result = Result::first();
		$videoquestion = VideoQuestion::find($result->videoquestion_id);
		$question = $videoquestion->question->first();
		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],['question_id' => $question->id, 'result_id' => $result->id]
		);

		$this->assertResponseStatus(400);	
	}
}
