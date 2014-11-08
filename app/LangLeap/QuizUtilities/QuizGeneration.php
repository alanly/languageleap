<?php namespace LangLeap\QuizUtilities;

use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\Question;
use LangLeap\Words\Definition;

/**
*  @author Thomas Rahn <thomas@rahn.ca>
*/
class QuizGeneration {

	/**
	*  		This function will generate a quiz based on the definitions sent in. This quiz will NOT be associated with a video.
	*		
	*		@param $definitions An Array of definiton
	*		@param $selected_words an Array of definitions Ids that the user selected as dificult
	*
	*		@return $quiz The id of the quiz that was generated.
	*/
	public static function generateQuiz($definitions, $selected_words)
	{
		$quiz = new Quiz;	
		$quiz->user_id = 1;
		$quiz->save();

		$questions = array();

		if( $selected_words){
			foreach ($selected_words as $definitionId) 
			{
				$definition = $definitions[$definitionId];

				//Create the question
				$question = new Question;
				$question->quiz_id = $quiz->id;
				$question->definition_id = $definitionId;
				$question->question = "What is the definition for " . $definition->word;
				$question->save();
				array_push($questions, $question);
			}
		}		

		return $quiz;
	}


}

