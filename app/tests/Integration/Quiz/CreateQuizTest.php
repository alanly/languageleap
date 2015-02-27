<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;
use LangLeap\Videos\Video;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Quizzes\Quiz;

class CreateQuizTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
		$this->be(User::where('is_admin', '=', true)->first());
	}

	//1. Request a video
	//2. Select a word from the script and create a quiz
	//3. Do the quiz correctly
	//4. Get redirected to next video
	//5. Check for the word in the wordbank (should be empty)
	public function testCreateQuizAnswerCorrectly()
	{
		$video = $this->getVideo();
		$wordFromScript = $this->getWordFromScript($video);
		$quiz = $this->createQuiz($video->video->id, $wordFromScript);
		$videoQuestions = $this->getVideoQuestions($quiz->quiz_id);
		$this->answerQuizCorrectly($videoQuestions);
		$words = $this->getWordsInBank();
		$this->assertSame(count($words), 0);
	}

	//1. Request a video
	//2. Select a word from the script and create a quiz
	//3. Do the quiz incorrectly
	//4. Get redirected to next video
	//5. Check for the word in the wordbank (should have 1 word)
	public function testCreateQuizAnswerIncorrectly()
	{
		$video = $this->getVideo();
		$wordFromScript = $this->getWordFromScript($video);
		$quiz = $this->createQuiz($video->video->id, $wordFromScript);
		$videoQuestions = $this->getVideoQuestions($quiz->quiz_id);
		$this->answerQuizIncorrectly($videoQuestions);
		$words = $this->getWordsInBank();
		$this->assertSame(count($words), 1);
		$this->assertSame(strtolower($words[0]->definition->word), strtolower($wordFromScript));
	}

	private function getVideo()
	{
		$video = Video::first();
		$response = $this->action(
			'get',
			'ApiVideoController@show',
			[$video->id]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('video', $data);

		return $data;
	}

	private function createQuiz($videoId, $word)
	{
		$selected_words = 
		[
			['word' => $word, 'definition' => 'Some definition', 'sentence' => $word . ' is annoying.']
		];

		$response = $this->action(
			'post',
			'ApiQuizController@postVideo',
			[],
			[
				"video_id" => $videoId, 
				"selected_words" => $selected_words
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		
		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('quiz_id', $data);
		$this->assertGreaterThan(0, $data->quiz_id);

		return $data;
	}

	private function getWordFromScript($video)
	{
		$wordsInScript = $video->video->script->text;
		$wordsInScript = trim(preg_replace('/\s*\<[^>]*\>\s*/', ' ', $wordsInScript));

		$words = str_word_count($wordsInScript, 1);
		return $words[1];
	}

	private function answerQuizCorrectly($videoQuestions)
	{
		foreach($videoQuestions as $vq)
		{
			$videoQuestion = VideoQuestion::find($vq->id);
			$selected_id = $videoQuestion->question->answer_id;
			$quiz = $videoQuestion->quiz()->first();
			$prevScore = $quiz->score;
			
			$response = $this->action(
				'PUT',
				'ApiQuizController@putIndex',
				[],
				[
					'videoquestion_id' => $videoQuestion->id, 
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
	}

	private function answerQuizIncorrectly($videoQuestions)
	{
		foreach($videoQuestions as $vq)
		{
			$videoQuestion = VideoQuestion::find($vq->id);
			$selected_id = $videoQuestion->question->answers->filter(function($answer) {return $answer->id != $answer->question->answer_id;})->first()->id;
			$quiz_id = $videoQuestion->quiz()->first()->id;
			
			$response = $this->action(
				'put',
				'ApiQuizController@putIndex',
				[],
				[
					'videoquestion_id' => $videoQuestion->id, 
					'selected_id' => $selected_id, 
					'quiz_id' => $quiz_id
				]
			);
			
			$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
			$this->assertResponseOk();
			
			$data = $response->getData()->data;
			$this->assertFalse($data->is_correct);
		}
	}

	private function getVideoQuestions($quizId)
	{
		$response = $this->action(
			'POST',
			'ApiQuizController@postIndex',
			[],
			[
				"quiz_id" => $quizId
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

		return $data->video_questions;
	}

	private function getWordsInBank()
	{
		$response = $this->action('GET', 'ApiReviewWordsController@getIndex');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());

		return $response->getData()->data;
	}
}
