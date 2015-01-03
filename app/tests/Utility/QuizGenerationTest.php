<?php

use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Quizzes\Quiz;
use LangLeap\Words\Definition;
use LangLeap\QuizUtilities\QuizGeneration;

class QuizGenerationTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}

	public function testQuizReturned()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(Definition::first());

		$quiz = QuizGeneration::generateQuiz($all_words,$selected_words);

		$this->assertInstanceOf('LangLeap\Quizzes\Quiz', $quiz);
	}
	
	public function testNullReturnedWhenWordsAreNotSelected()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array();

		$quiz = QuizGeneration::generateQuiz($all_words,$selected_words);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenInvalidWordsAreSelected()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(-1);

		$quiz = QuizGeneration::generateQuiz($all_words, $selected_words);

		$this->assertNull($quiz);
	}

	public function testNullReturnedWhenScriptWordsNotSupplied()
	{
		$all_words = new Collection;
		$selected_words = array(Definition::first()->id);

		$quiz = QuizGeneration::generateQuiz($all_words,$selected_words);

		$this->assertNull($quiz);
	}
}
