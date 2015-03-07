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

	/*
	 * This method will test the postIndex method of the ApiQuizController.
	 */
	public function testIndex()
	{
		$quiz = Quiz::first();
		
		$response = $this->action(
			'POST',
			'ApiQuizController@postIndex',
			[],
			[
				"quiz_id" => $quiz->id
			]
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
		}
	}
	
	/**
	 * This test will check if a quiz is created when submitting words to the ApiQuizController
	 */
	public function testVideo()
	{
		$video = Video::first();
		$selected_words = 
		[
			['word' => 'cat', 'definition' => 'lazy animal', 'sentence' => 'the cat is annoying.'],
			['word' => 'dog', 'definition' => '', 'sentence' => 'the dog is lovely.'],
			['word' => 'elephant', 'definition' => 'large land animal', 'sentence' => 'the elephant is huge.']
		];

		$response = $this->action(
			'post',
			'ApiQuizController@postVideo',
			[],
			[
				"video_id" => $video->id, 
				"selected_words" => $selected_words
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		
		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('quiz_id', $data);
		$this->assertGreaterThan(0, $data->quiz_id);
	}

	/**
	 * This test will check if a 404 is returned when 1 of the words sent to the backend is empty
	 */
	public function testVideoInvalidWord()
	{
		$video = Video::first();
		$selected_words = 
		[
			['word' => 'cat', 'definition' => 'lazy animal', 'sentence' => 'the cat is annoying.'],
			['word' => '', 'definition' => '', 'sentence' => 'the dog is lovely.'],
			['word' => 'elephant', 'definition' => 'large land animal', 'sentence' => 'the elephant is huge.']
		];

		$response = $this->action(
			'post',
			'ApiQuizController@postVideo',
			[],
			[
				"video_id" => $video->id, 
				"selected_words" => $selected_words
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	/**
	 * This test will check if a 404 is returned when 1 of the sentences sent to the backend is empty
	 */
	public function testVideoInvalidSentence()
	{
		$video = Video::first();
		$selected_words = 
		[
			['word' => 'cat', 'definition' => 'lazy animal', 'sentence' => ''],
			['word' => 'dog', 'definition' => '', 'sentence' => 'the dog is lovely.'],
			['word' => 'elephant', 'definition' => 'large land animal', 'sentence' => 'the elephant is huge.']
		];

		$response = $this->action(
			'post',
			'ApiQuizController@postVideo',
			[],
			[
				"video_id" => $video->id, 
				"selected_words" => $selected_words
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}

	/**
	 * This test will check if a 404 is returned when 1 of the words isn't found in the sentence
	 */
	public function testVideoWordNotInSentence()
	{
		$video = Video::first();
		$selected_words = 
		[
			['word' => 'cat', 'definition' => 'lazy animal', 'sentence' => 'dog'],
			['word' => 'dog', 'definition' => '', 'sentence' => 'the dog is lovely.'],
			['word' => 'elephant', 'definition' => 'large land animal', 'sentence' => 'the elephant is huge.']
		];

		$response = $this->action(
			'post',
			'ApiQuizController@postVideo',
			[],
			[
				"video_id" => $video->id, 
				"selected_words" => $selected_words
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}

	/**
	 * This test will check for a correct response when only 1 word is selected, and the API returned no definition.
	 */	
	public function testVideoNoDefinitionForWordSelected()
	{
		$video = Video::first();
		$selected_words = 
		[
			['word' => 'thiswordhasnodefinition', 'definition' => '', 'sentence' => 'thiswordhasnodefinition is nice.']
		];

		$response = $this->action(
			'post',
			'ApiQuizController@postVideo',
			[],
			[
				"video_id" => $video->id, 
				"selected_words" => $selected_words
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	/**
	 * This test will check for a correct response when 2 words are selected, and the API returned no definition for both.
	 */	
	public function testVideoNoDefinitionForWordsSelected()
	{
		$video = Video::first();
		$selected_words = 
		[
			['word' => 'thiswordhasnodefinition', 'definition' => '', 'sentence' => 'thiswordhasnodefinition is nice.'],
			['word' => 'thiswordhasnodefinition', 'definition' => '', 'sentence' => 'thiswordhasnodefinition is nice.']
		];

		$response = $this->action(
			'post',
			'ApiQuizController@postVideo',
			[],
			[
				"video_id" => $video->id, 
				"selected_words" => $selected_words
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	/**
	 * This test will check for a correct response when only 1 word is selected, and the API returned no definition.
	 * However, there are other words selected with a definition
	 */	
	public function testVideoNoDefinitionForOneOfTheWordSelected()
	{
		$video = Video::first();
		$selected_words = 
		[
			['word' => 'cat', 'definition' => 'lazy animal', 'sentence' => 'the cat is annoying.'],
			['word' => 'thiswordhasnodefinition', 'definition' => '', 'sentence' => 'thiswordhasnodefinition is nice.']
		];

		$response = $this->action(
			'post',
			'ApiQuizController@postVideo',
			[],
			[
				"video_id" => $video->id, 
				"selected_words" => $selected_words
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		
		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('quiz_id', $data);
		$this->assertGreaterThan(0, $data->quiz_id);
	}

	/*
	 *	This test will test that a proper error code is recieved when trying to get a quiz with an invalid video
	 */
	public function testIndexWithInvalidVideo()
	{

		$definition = Definition::all();
		$selected_words = 
		[
			['word' => 'cat', 'definition' => 'lazy animal', 'sentence' => 'the cat is annoying.'],
			['word' => 'dog', 'definition' => '', 'sentence' => 'the dog is lovely.'],
			['word' => 'elephant', 'definition' => 'large land animal', 'sentence' => 'the elephant is huge.']
		];

		$response = $this->action(
			'post',
			'ApiQuizController@postVideo',
			[],
			[
				"video_id" => -1,  
				"selected_words" => $selected_words
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	/*
	 *	This test verifies that an 404 error will be returned when trying to answer a question that does not exist.
	 *	404 == Not found
	 */
	public function testQuizUpdateWithInvalidQuestion()
	{
		$response = $this->action(
			'put',
			'ApiQuizController@putIndex',
			[],
			[
				'videoquestion_id' => -1, 
				'selected_id' => 1, 
				'quiz_id' => 1
			]
		);
		
		$this->assertResponseStatus(404);	
	}
	
	/*
	 * This test will verify that a 400 error will be returned when trying to answer with no selected id.
	 * 400 == Bad Request
	 */
	public function testQuizUpdateWithNoAnswer()
	{
		$videoquestion = VideoQuestion::first();
		$quiz = $videoquestion->quiz()->first();
		$response = $this->action(
			'PUT',
			'ApiQuizController@putIndex',
			[],
			[
				'videoquestion_id' => $videoquestion->id, 
				'quiz_id' => $quiz->id
			]
		);

		$this->assertResponseStatus(400);	
	}
	
	/*
	 * This method will test the putIndex method of the ApiQuizController.
	 */
	public function testQuizUpdateCorrect()
	{
		$videoquestion = VideoQuestion::first();
		$selected_id = $videoquestion->question->answer_id;
		$quiz = $videoquestion->quiz()->first();
		$prevScore = $quiz->score;
		
		$response = $this->action(
			'PUT',
			'ApiQuizController@putIndex',
			[],
			[
				'videoquestion_id' => $videoquestion->id, 
				'selected_id' => $selected_id, 
				'quiz_id' => $quiz->id
			]
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
			[],
			[
				'videoquestion_id' => $videoquestion->id, 
				'selected_id' => $selected_id, 
				'quiz_id' => $quiz_id
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		
		$data = $response->getData()->data;
		$this->assertFalse($data->is_correct);
	}
	
	public function testPutCustomQuestion()
	{
		$video = Video::first();
		$question = 'test question';
		$answers = ['1', '2', '3', '4'];
		
		$response = $this->action(
			'PUT',
			'ApiQuizController@putCustomQuestion',
			[], 
			[
				'video_id' => $video->id, 
				'question' => $question, 
				'answer' => $answers
			]
		);
		
		$this->assertRedirectedTo('admin/quiz/new');
		
		$this->assertSessionHas('success', true);
		$this->assertSessionHas('message');
	}
	
	public function testPutCustomQuestionInvalidVideo()
	{
		$question = 'test question';
		$answers = ['1', '2', '3', '4'];
		
		$response = $this->action(
			'PUT',
			'ApiQuizController@putCustomQuestion',
			[], 
			[
				'video_id' => -1, 
				'question' => $question, 
				'answer' => $answers
			]
		);
		
		$this->assertRedirectedTo('admin/quiz/new');
		
		$this->assertSessionHas('success', false);
		$this->assertSessionHas('message');
	}
	
	public function testPutCustomQuestionInvalidAnswers()
	{
		$video = Video::first();
		$question = 'test question';
		$answers = [];
		
		$response = $this->action(
			'PUT',
			'ApiQuizController@putCustomQuestion',
			[], 
			[
				'video_id' => $video->id, 
				'question' => $question, 
				'answer' => $answers
			]
		);
		
		$this->assertRedirectedTo('admin/quiz/new');
		
		$this->assertSessionHas('success', false);
		$this->assertSessionHas('message');
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
	
	public function testQuizScoreNoQuiz()
	{
		$response = $this->call('GET', 'api/quiz/score/-1');
		$this->assertResponseStatus(404);
	}
	
	public function testQuizScoreUnauthorized()
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
	
	public function testVideoScores()
	{
		$response = $this->call(
			'get',
			'api/quiz/video-scores'
		);
		
		$this->assertResponseOk();
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		
		$data = $response->getData()->data;
		$this->assertNotEmpty($data);
		foreach($data as $video_score)
		{
			$this->assertObjectHasAttribute('video', $video_score);
			$this->assertObjectHasAttribute('score', $video_score);
		}
	}
}
