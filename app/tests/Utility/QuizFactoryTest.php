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
		$this->be(User::first());
	}

	public function testQuestionReturned()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(Definition::first()->id);
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $all_words, $selected_words);

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
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array();
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $all_words, $selected_words);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenInvalidWordsAreSelected()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(-1);
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $all_words, $selected_words);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenScriptWordsNotSupplied()
	{
		$all_words = new Collection([]);
		$selected_words = array(Definition::first()->id);
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $all_words, $selected_words);

		$this->assertNull($quiz);
	}
	
	public function testNullWhenVideoDoesNotExist()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(Definition::first());
		$video_id = -1;
		
		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $all_words, $selected_words);
		
		$this->assertNull($quiz);
	}
	
	public function testNullReturnedWhenUserDoesNotExist()
	{
		$user = App::make('\LangLeap\Accounts\User');
		$user->id = -1;
		$this->be($user);
		
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(Definition::first()->id);
		$video_id = Video::first()->id;
		
		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $video_id, $all_words, $selected_words);

		$this->assertNull($quiz);
	}
}
