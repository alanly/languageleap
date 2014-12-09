<?php

use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\Quiz;
use LangLeap\Words\Definition;
use LangLeap\QuizUtilities\QuizFactory;

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

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz($all_words, $selected_words);

		foreach($quiz->questions() as $q)
		{
			$this->assertInstanceOf('LangLeap\Quizzes\Question', $q);
		}
	}
	
	public function testNullReturnedWhenWordsAreNotSelected()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array();

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz($all_words, $selected_words);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenInvalidWordsAreSelected()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(-1);

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz($all_words, $selected_words);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenScriptWordsNotSupplied()
	{
		$all_words = new Collection;
		$selected_words = array(Definition::first()->id);

		$quiz = QuizFactory::getInstance()->getDefinitionQuiz($all_words, $selected_words);

		$this->assertNull($quiz);
	}
}
