<?php

use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Words\Definition;
use LangLeap\QuizUtilities\QuizFactory;
use LangLeap\Videos\Video;
use LangLeap\Accounts\User;

class QuizFactoryTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}

	public function testQuestionReturned()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(Definition::first());
		$video_id = Video::first()->id;
		$user_id = User::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz($user_id, $video_id, $all_words, $selected_words);

		foreach($quiz->videoQuestions() as $vq)
		{
			$this->assertInstanceOf('LangLeap\Quizzes\VideoQuestion', $vq);
			foreach($vq->questions as $q)
			{
				$this->assertGreaterThan(1, $q->answers()->count());
			}
		}
	}
	
	public function testNullReturnedWhenWordsAreNotSelected()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array();
		$video_id = Video::first()->id;
		$user_id = User::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz($user_id, $video_id, $all_words, $selected_words);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenInvalidWordsAreSelected()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(-1);
		$video_id = Video::first()->id;
		$user_id = User::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz($user_id, $video_id, $all_words, $selected_words);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenScriptWordsNotSupplied()
	{
		$all_words = new Collection;
		$selected_words = array(Definition::first()->id);
		$video_id = Video::first()->id;
		$user_id = User::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz($user_id, $video_id, $all_words, $selected_words);

		$this->assertNull($quiz);
	}
	
	public function testNullWhenVideoDoesNotExist()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(Definition::first());
		$user_id = User::first()->id;
		
		$quiz = QuizFactory::getInstance()->getDefinitionQuiz($user_id, -1, $all_words, $selected_words);
		
		$this->assertNull($quiz);
	}
	
	public function testNullReturnedWhenUserDoesNotExist()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(Definition::first()->id);
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(-1, $video_id, $all_words, $selected_words);

		$this->assertNull($quiz);
	}
}