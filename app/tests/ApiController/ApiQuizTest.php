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
	*	This method will test the postIndex method of the ApiQuizController.
	*
	*	The response should be a JSON string in the format:
	* {"status":"success",
	* "data":
	*	{"id":2,
	* 	"video_questions":
	*		[
	* 			{"id":"4",
	* 			"question":"What is the definition of Hello?",
	*			"answers":
	*				[
	* 					{"id":"8",	"answer":"used as a greeting or to begin a telephone conversation."},
	* 					{"id":"9",	"answer":"a system that converts acoustic vibrations to electrical signals in order to transmit sound, typically voices, over a distance using wire or radio."},
	* 					{"id":"10",	"answer":"a description a word"},
	* 					{"id":"11",	"answer":"made, done, happening, or chosen without method or conscious decision."}
	* 				]
	* 			}
	*		]
	*	 }
	* } 
	*/
	public function testIndex()
	{
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
		$this->assertObjectHasAttribute('id', $data);
		$this->assertObjectHasAttribute('video_questions', $data);

		$videoQuestions = $data->video_questions;
		$this->assertGreaterThan(0, count($videoQuestions));
		foreach($data->video_questions as $vq)
		{
			$this->assertObjectHasAttribute('id', $vq);
			$this->assertObjectHasAttribute('question', $vq);
			$this->assertObjectHasAttribute('answers', $vq);
			$this->assertGreaterThan(1, count($vq->answers));
		}
	}

	/**
	*	This test will test if a proper error code is recieved when trying to get a quiz with no/invalid deinitions
	*
	*/
	public function testIndexWithNoDefinitions()
	{
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
	public function testIndexWithInvalidVideo()
	{

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
	public function testQuizUpdateWithInvalidQuestion()
	{
		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],['question_id' => -1]
		);
		
		$this->assertResponseStatus(404);	
	}
	
	/**
	*	This test will verify that a 400 error will be returned when trying to answer with no selected id.
	*	400 == Bad Request
	*
	*/
	public function testQuizUpdateWithNoAnswer()
	{
		$videoquestion = VideoQuestion::first();
		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],['videoquestion_id' => $videoquestion->id]
		);

		$this->assertResponseStatus(400);	
	}
	
	public function testQuizUpdate()
	{
		$videoquestion = VideoQuestion::first();
		$selected_id = $videoquestion->question->answers->first()->id;
		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],['videoquestion_id' => $videoquestion->id, 'selected_id' => $selected_id]
		);
		
		$this->assertResponseOk();
	}
}
