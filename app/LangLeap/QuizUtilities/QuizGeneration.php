<?php namespace LangLeap\QuizUtilities;

use LangLeap\Quizzes\Quiz;

class QuizGeneration {

	/**
	*       @author Thomas Rahn <thomas@rahn.ca>
	*		
	*		@param $all_words An Array of definiton Ids
	*		@param $selected_words an Array of definitions Ids that the user selected as dificult
	*
	*		@return $quiz The id of the quiz that was generated.
	*/
	public static function generateQuiz($all_words, $selected_words)
	{
		$quiz = new Quiz;	
		$quiz->user_id = 1;
		$quiz->save();


		return $quiz;
	}


}

