<?php

use LangLeap\TestCase;
use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Words\Definition;
use LangLeap\QuizUtilities\QuizGeneration;

class QuizGenerationTest extends TestCase {

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

		$questions = QuizGeneration::generateDefinitionQuiz($all_words, $selected_words);

		foreach($questions as $q)
		{
			$this->assertInstanceOf('LangLeap\Quizzes\Question', $q);
		}
	}
	
	public function testNullReturnedWhenWordsAreNotSelected()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array();

		$question = QuizGeneration::generateDefinitionQuiz($all_words, $selected_words);

		$this->assertNull($question);
	}

	public function testNullReturnedWhenInvalidWordsAreSelected()
	{
		$all_words = new Collection(Definition::all()->all());
		$selected_words = array(-1);

		$question = QuizGeneration::generateDefinitionQuiz($all_words, $selected_words);

		$this->assertNull($question);
	}

	public function testNullReturnedWhenScriptWordsNotSupplied()
	{
		$all_words = new Collection;
		$selected_words = array(Definition::first()->id);

		$question = QuizGeneration::generateDefinitionQuiz($all_words, $selected_words);

		$this->assertNull($question);
	}
}
