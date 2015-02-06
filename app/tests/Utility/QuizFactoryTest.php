<?php

use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Words\Definition;
use LangLeap\QuizUtilities\QuizFactory;
use LangLeap\Videos\Video;
use LangLeap\Accounts\User;
use LangLeap\WordUtilities\WordInformation;

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
			new WordInformation('cat', 'vicious, animal', 'the cat is annoying', $video_id),
			new WordInformation('dog', 'barking animal', 'the dog is cute', $video_id),
			new WordInformation('elephant', 'large land animal', 'the elephany is huge', $video_id),
		];

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $wordsInformation);

		$this->assertNotEmpty($quiz->videoQuestions);

		foreach ($quiz->videoQuestions as $vq)
		{
			$this->assertInstanceOf('LangLeap\Quizzes\VideoQuestion', $vq);
			$question = $vq->question;
			$this->assertGreaterThan(1, $question->answers->count());
		}
	}
	
	public function testNullReturnedWhenWordsAreNotSelected()
	{
		$video_id = Video::first()->id;
		$wordsInformation = [];
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $wordsInformation);

		$this->assertNull($quiz);
	}
	
	public function testNullWhenVideoDoesNotExist()
	{
		$video_id = -1;
		$wordsInformation = [
			new WordInformation('cat', 'vicious, animal', 'the cat is annoying', 1),
		];
		
		
		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $wordsInformation);
		
		$this->assertNull($quiz);
	}
	
	public function testNullReturnedWhenUserDoesNotExist()
	{
		$user = App::make('\LangLeap\Accounts\User');
		$user->id = -1;
		$this->be($user);
		$video_id = Video::first()->id;
		$wordsInformation = [
			new WordInformation('cat', 'vicious, animal', 'the cat is annoying', $video_id),
			new WordInformation('dog', 'barking animal', 'the dog is cute', $video_id),
			new WordInformation('elephant', 'large land animal', 'the elephany is huge', $video_id),
		];
		
		
		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $wordsInformation);

		$this->assertNull($quiz);
	}
}
