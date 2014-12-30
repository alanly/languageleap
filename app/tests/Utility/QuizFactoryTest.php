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
		$definition_ids = Definition::all(['id']);
		$all_words = [];
		foreach($definition_ids as $did)
		{
			$all_words[] = $did->id;
		}
		$selected_words = array(Definition::first()->id);
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->response(Auth::user()->id, ['video_id' => $video_id, 'all_words' => $all_words , 'selected_words' => $selected_words]);

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
		$definition_ids = Definition::all(['id']);
		$all_words = [];
		foreach($definition_ids as $did)
		{
			$all_words[] = $did->id;
		}
		$selected_words = array();
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->response(Auth::user()->id, ['video_id' => $video_id, 'all_words' => $all_words, 'selected_words' => $selected_words]);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenInvalidWordsAreSelected()
	{
		$definition_ids = Definition::all(['id']);
		$all_words = [];
		foreach($definition_ids as $did)
		{
			$all_words[] = $did->id;
		}
		$selected_words = array(-1);
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->response(Auth::user()->id, ['video_id' => $video_id, 'all_words' => $all_words, 'selected_words' => $selected_words]);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenScriptWordsNotSupplied()
	{
		$all_words = [];
		$selected_words = array(Definition::first()->id);
		$video_id = Video::first()->id;

		$quiz = QuizFactory::getInstance()->response(Auth::user()->id, ['video_id' => $video_id, 'all_words' => $all_words, 'selected_words' => $selected_words]);

		$this->assertNull($quiz);
	}
	
	public function testNullWhenVideoDoesNotExist()
	{
		$definition_ids = Definition::all(['id']);
		$all_words = [];
		foreach($definition_ids as $did)
		{
			$all_words[] = $did->id;
		}
		$selected_words = array(Definition::first());
		
		$quiz = QuizFactory::getInstance()->response(Auth::user()->id, ['video_id' => -1, 'all_words' => $all_words, 'selected_words' => $selected_words]);
		
		$this->assertNull($quiz);
	}
	
	public function testNullReturnedWhenUserDoesNotExist()
	{
		$user = App::make('\LangLeap\Accounts\User');
		$user->id = -1;
		$this->be($user);
		$definition_ids = Definition::all(['id']);
		$all_words = [];
		foreach($definition_ids as $did)
		{
			$all_words[] = $did->id;
		}
		$selected_words = array(Definition::first()->id);
		$video_id = Video::first()->id;
		
		$quiz = QuizFactory::getInstance()->response(Auth::user()->id, ['video_id' => $video_id, 'all_words' => $all_words, 'selected_words' => $selected_words]);

		$this->assertNull($quiz);
	}
}
