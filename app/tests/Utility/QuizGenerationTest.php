<?php

use LangLeap\TestCase;
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
	
	public function testQuizGeneration()
	{
		$all_words = array(Definition::all()->first());
		$selected_words = array();

		$quiz = QuizGeneration::generateQuiz($all_words,$selected_words);

		//Assert that a valid quiz has been sent back.
		$this->assertNotNull($quiz);
	}

	public function testQuizGenerationWithNoDefinitions()
	{
		$all_words = array();
		$selected_words = array();

		$quiz = QuizGeneration::generateQuiz($all_words,$selected_words);

		//Assert that a valid quiz has been sent back.
		$this->assertNull($quiz);
	}
}
