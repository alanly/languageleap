<?php

use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\Result;

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
			'post',
			'ApiQuizController@postIndex',
			[],["video_id"=>$video->id, "all_words" => $all_words, "selected_words" => $selected_words]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('videoquestion_id', $data);
		$this->assertObjectHasAttribute('question', $data);

		$question = $data->question;
		$this->assertObjectHasAttribute('id', $question);
		$this->assertObjectHasAttribute('question', $question);
		$this->assertObjectHasAttribute('answer_id', $question);
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
	public function atestIndexWithInvalidVideo(){

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
	*	This test will test that answering a question is successful
	*
	*/
	public function atestQuizUpdate() {
		$quiz = Quiz::first();
		$video = Video::find($quiz->video_id);
		$question = $quiz->questions()->first();

		$this->session(['scriptDefinitions' => new Collection(Definition::all()->all())]);

		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],["question_id"=>$question->id, "video_id"=>$video->id, "selected_id" => $question->definition_id]
		);

		$this->assertResponseStatus(200);
	}

	/**
	*	This test verifies that an 404 error will be returned when trying to answer a question that does not exist.
	*	404 == Not found
	*
	*/
	public function atestQuizUpdateWithInvalidQuestion(){
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
	public function atestQuizUpdateWithNoAnswer(){
		$quiz = Quiz::first();
		$video = Video::find($quiz->video_id);
		$question = $quiz->questions()->first();
		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],['question_id' => $question->id, 'video_id' => $video->id]
		);

		$this->assertResponseStatus(400);	
	}
}
