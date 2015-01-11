<?php

use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\Result;
use LangLeap\Quizzes\Quiz;
use LangLeap\Accounts\User;

class ApiQuizControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database and login
		$this->seed();
		$this->be(User::where('is_admin', '=', true)->first());
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
			[],['videoquestion_id' => -1, 'selected_id' => 1, 'quiz_id' => 1]
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
			[],['videoquestion_id' => 1, 'quiz_id' => 1]
		);

		$this->assertResponseStatus(400);	
	}
	
	/**
	*	This method will test the putIndex method of the ApiQuizController.
	*
	*	The response should be a JSON string in the format:
	*	{"status":"success", "data":{"is_correct":"true"} } 
	*/
	public function testQuizUpdateCorrect()
	{
		$videoquestion = VideoQuestion::first();
		$selected_id = $videoquestion->question->answer_id;
		$quiz = $videoquestion->quiz()->first();
		$prevScore = $quiz->score;
		
		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],['videoquestion_id' => $videoquestion->id, 'selected_id' => $selected_id, 'quiz_id' => $quiz->id]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		
		$data = $response->getData()->data;
		$this->assertTrue($data->is_correct);
		
		$this->assertGreaterThan($prevScore, Quiz::find($quiz->id)->score); // Check score updates
	}
	
	public function testQuizUpdateIncorrect()
	{
		$videoquestion = VideoQuestion::first();
		
		$selected_id = $videoquestion->question->answers->filter(function($answer) {return $answer->id != $answer->question->answer_id;})->first()->id;
		$quiz_id = $videoquestion->quiz()->first()->id;
		
		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],['videoquestion_id' => $videoquestion->id, 'selected_id' => $selected_id, 'quiz_id' => $quiz_id]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		
		$data = $response->getData()->data;
		$this->assertFalse($data->is_correct);
	}
	
	public function testQuizScore()
	{
		$quiz = Quiz::first();
		$response = $this->call(
			'get',
			'api/quiz/score/'.$quiz->id
		);
		
		$this->assertResponseOk();
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		
		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('score', $data);
	}
	
	public function testQuizUnauthorized()
	{
		$user = User::where('is_admin', '=', false)->first();
		$this->be($user);
		$quiz = Quiz::where('user_id', '<>', $user->id)->first();
		$response = $this->call(
			'get',
			'api/quiz/score/'.$quiz->id
		);
		
		$this->assertResponseStatus(401);
	}
	
	public function testReminder()
	{
		$response = $this->call(
			'get',
			'api/quiz/reminder'
		);
		
		$this->assertResponseOk();
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		
		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('quiz_id', $data);
	}
}
