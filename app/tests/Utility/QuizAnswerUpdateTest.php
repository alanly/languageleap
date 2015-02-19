<?php

use LangLeap\TestCase;
use LangLeap\Words\WordBank;
use LangLeap\QuizUtilities\QuizAnswerUpdate;

class QuizAnswerUpdateTest extends TestCase {

	private $quiz;
	private $question;
	private $definitionQuestion;
	private $videoQuestion;
	private $video;

	public function setUp()
	{
		parent::setUp();
		$this->saveQuizDependencies();
	}
	
	/**
	 * Test that the QuizAnswerUpdate returns correct and no WordBank instance has been created.
	 */
	public function testResponseCorrect()
	{
		$input = ['quiz_id' => $this->quiz->id, 'selected_id' => '1', 'videoquestion_id' => $this->videoQuestion->id];
		$user = $this->getUserInstance();
		
		$quizAnswerUpdate = new QuizAnswerUpdate;
		$response = $quizAnswerUpdate->response($user, $input);
		
		$this->assertCount(3, $response);
		$this->assertInternalType('string', $response[0]);
		$this->assertTrue($response[1]['is_correct']);
		$this->assertInternalType('int', $response[2]);
		
		$this->assertCount(0, WordBank::all());
	}
	
	/**
	 * Test that QuizAnswerUpdate returns incorrect and a WordBank instance has been created.
	 */
	public function testResponseIncorrect()
	{
		$input = ['quiz_id' => $this->quiz->id, 'selected_id' => '2', 'videoquestion_id' => $this->videoQuestion->id];
		$user = $this->getUserInstance();
		
		$quizAnswerUpdate = new QuizAnswerUpdate;
		$response = $quizAnswerUpdate->response($user, $input);
		
		$this->assertCount(3, $response);
		$this->assertInternalType('string', $response[0]);
		$this->assertFalse($response[1]['is_correct']);
		$this->assertInternalType('int', $response[2]);
		
		$wordbank = WordBank::where('user_id', '=', $user->id)->first();
		$this->assertNotNull($wordbank);
		$this->assertEquals(1, $wordbank->definition_id);
	}
	
	protected function getUserInstance()
	{
		$user = App::make('LangLeap\Accounts\User');
		$user->username = 'username';
		$user->email = 'username@email.com';
		$user->password = 'password';
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->language_id = 1;
		$user->is_admin = true;
		$user->save();
		
		return $user;
	}
	
	protected function saveQuizDependencies()
	{
		$quiz = App::make('LangLeap\Quizzes\Quiz');
		$question = App::make('LangLeap\Questions\Question');
		$dq = App::make('LangLeap\Questions\DefinitionQuestion');
		$videoquestion = App::make('LangLeap\Quizzes\VideoQuestion');
		$video = App::make('LangLeap\Videos\Video');
		
		$this->video = $video->create([
			'path' => '/path/to/somewhere/1.mkv', 
			'language_id'   => 1,
			'viewable_id' => 1,
			'viewable_type' => 'LangLeap\Videos\Commercial'
		]);
		
		$this->quiz = $quiz->create([
			'user_id' => 1
		]);
		
		$this->definitionQuestion = $dq->create([
			'question' => 'What is the definition of hello?',
			'word' => 'hello'
		]);
		
		$this->question = $question->create([
			"question_type" => "LangLeap\Questions\DefinitionQuestion", 
			"question_id" => $this->definitionQuestion->id, 
			"answer_id" => 1
		]);
		
		$this->videoQuestion = $videoquestion->create([
			'video_id' => $this->video->id, 
			'question_id' => $this->question->id, 
			'is_custom' => false
		]);
		
		$this->quiz->videoQuestions()->attach($this->videoQuestion);
	}
}
