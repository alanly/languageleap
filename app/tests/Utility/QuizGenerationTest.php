<?php

use LangLeap\TestCase;
use LangLeap\Quizzes\Quiz;
use LangLeap\QuizUtilities\QuizGeneration;

class QuizGenerationTest extends TestCase {

	
	public function testQuizGeneration()
	{
		$this->seed();

		$all_words = array();
		$selected_words = array();

		$quiz = QuizGeneration::generateQuiz($all_words,$selected_words);

		//Assert that a valid quiz has been sent back.
		$this->assertNotNull($quiz);
	}
}
