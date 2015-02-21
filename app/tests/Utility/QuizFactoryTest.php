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
			['word' => 'cat', 'definition' => 'vicious, animal', 'sentence' => 'the cat is annoying'],
			['word' => 'dog', 'definition' => 'barking animal', 'sentence' => 'the dog is cute'],
			['word' => 'elephant', 'definition' => 'large land animal', 'sentence' => 'the elephany is huge'],
		];

		$quiz = QuizFactory::getInstance()->getVideoQuiz(Auth::user()->id, $video_id, $wordsInformation);

		$this->assertNotEmpty($quiz->videoQuestions);

		foreach ($quiz->videoQuestions as $vq)
		{
			$this->assertInstanceOf('LangLeap\Quizzes\VideoQuestion', $vq);
			$question = $vq->question;
			$this->assertGreaterThan(1, $question->answers->count());
		}
	}
}
