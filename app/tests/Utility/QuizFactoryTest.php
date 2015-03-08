<?php

use LangLeap\TestCase;
use LangLeap\Quizzes\Quiz;
use LangLeap\QuizUtilities\QuizFactory;
use LangLeap\Accounts\User;
use LangLeap\Videos\Video;

class QuizFactoryTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
		$this->be(User::first());
	}

	public function testQuestionReturned()
	{
		$video_id = Video::first()->id;
		$wordsInformation = [
			['word' => 'cat', 'definition' => 'vicious, animal', 'sentence' => 'the cat is annoying'],
			['word' => 'dog', 'definition' => 'barking animal', 'sentence' => 'the dog is cute'],
			['word' => 'elephant', 'definition' => 'large land animal', 'sentence' => 'the elephany is huge'],
		];

		$quiz = QuizFactory::getInstance()->getVideoQuiz(Auth::user()->id, $video_id, $wordsInformation);

		$this->assertInstanceOf('LangLeap\Quizzes\VideoQuiz', $quiz->category);
		$this->assertNotEmpty($quiz->videoQuestions);

		foreach ($quiz->videoQuestions as $vq)
		{
			$this->assertInstanceOf('LangLeap\Quizzes\VideoQuestion', $vq);
			$question = $vq->question;
			$this->assertGreaterThan(1, $question->answers->count());
		}
	}
	
	public function testReminderNullWhenNoQuestions()
	{
		$user = User::first();
		$quiz = QuizFactory::getInstance()->getReminderQuiz($user->id);
		$this->assertNull($quiz);
	}
	
	public function testReminderWithPreviousIncorrectQuestion()
	{
		$this->saveQuizDependencies('LangLeap\Quizzes\VideoQuiz', ['video_id' => Video::first()->id]);
		
		$user = User::first();
		$quiz = QuizFactory::getInstance()->getReminderQuiz($user->id);
		
		$this->assertInstanceOf('LangLeap\Quizzes\Quiz', $quiz);
		$this->assertInstanceOf('LangLeap\Quizzes\ReminderQuiz', $quiz->category);
		$this->assertNotEmpty($quiz->videoQuestions);
	}
	
	public function testReminderWithPreviousReminderQuiz()
	{
		$user = User::first();
		$this->saveQuizDependencies('LangLeap\Quizzes\ReminderQuiz', ['attempted' => false]);
		
		$previousQuiz = Quiz::select('quizzes.*')->where('quizzes.user_id', '=', $user->id)->where('category_type', '=', 'LangLeap\Quizzes\ReminderQuiz')
								->join('reminder_quizzes', 'quizzes.category_id', '=', 'reminder_quizzes.id')->where('reminder_quizzes.attempted', '=', false)->first();
		
		$quiz = QuizFactory::getInstance()->getReminderQuiz($user->id);
		
		$this->assertInstanceOf('LangLeap\Quizzes\Quiz', $quiz);
		$this->assertInstanceOf('LangLeap\Quizzes\ReminderQuiz', $quiz->category);
		$this->assertEquals($previousQuiz->id, $quiz->id);
		$this->assertNotEmpty($quiz->videoQuestions);
	}
	
	protected function saveQuizDependencies($quizCategory, $categoryParams)
	{
		$category = App::make($quizCategory)->create($categoryParams);
		
		$quiz = App::make('LangLeap\Quizzes\Quiz')->create([
			'user_id' => User::first()->id,
			'category_type' => $quizCategory,
			'category_id' => $category->id,
		]);
		
		$dq = App::make('LangLeap\Questions\DefinitionQuestion')->create([
			'question' => 'What is the definition of hello?',
			'word' => 'hello'
		]);
		
		$question = App::make('LangLeap\Questions\Question')->create([
			"question_type" => "LangLeap\Questions\DefinitionQuestion", 
			"question_id" => $dq->id, 
			"answer_id" => 1
		]);
		
		$videoquestion = App::make('LangLeap\Quizzes\VideoQuestion')->create([
			'video_id' => Video::first()->id, 
			'question_id' => $question->id, 
			'is_custom' => false
		]);
		
		$quiz->videoQuestions()->attach($videoquestion->id, ['attempted' => true, 'is_correct' => false]);
	}
}
