<?php namespace LangLeap\QuizUtilities;

use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\Question;
use LangLeap\Words\Definition;

/**
*  @author Thomas Rahn <thomas@rahn.ca>
*/
class QuizGeneration {

	/**
	*		This function will generate a quiz based on the definitions sent in. This quiz will NOT be associated with a video.
	*		
	*		@param Definition[]  An Array of definiton that can be in the quiz
	*		@param String[] an Array of definitions Ids that the user selected as dificult
	*
	*		@return Quiz The quiz that was generated.
	*/
	public static function generateQuiz($definitions, $selected_words)
	{
		$quiz = new Quiz;	
		$quiz->user_id = 1;
		$quiz->save();

		$questions = array();

		//return null if there are no definitions
		if(! $definitions)
		{
			return null;
		}

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
				unset($definitions[$definitionId]);
			}
		}		

		if(count($questions) < 4) {

			$keys = array_keys($definitions);
			$index = 0;
			while($index < 3 - count($questions) && count($definitions) >= 1)
			{

				$definition = $definitions[$keys[$index]];

				$question = new Question;
				$question->quiz_id = $quiz->id;
				$question->definition_id = $keys[$index];
				$question->question = "What is the definition for " . $definition->word;
				$question->save();
				array_push($questions, $question);
				unset($definitions[$keys[$index]]);
				$index++;
			}
		}

		return $quiz;
	}

	/**
	*	This function will return an array of all the "definition" attributes of all the defintions.
	*	This is the function that will generate the possible answers for the question, it will also shuffle them so the answer isn't always on top.
	*
	*	@param Definition[] An array of definitions from the script.
	*	@param Int The definition Id of the answer.
	*
	*	@return An an array of deinitions
	*/
	public static function generateQuestionDefinitions($definitions, $answerId){
		$jsonDefinition = array();

		//add the answer
		array_push($jsonDefinition, $definitions[$answerId]->definition);
		unset($definitions[$answerId]);

		if(count($definitions)<= 4)
		{
			foreach($definitions as $def)
			{
				array_push($jsonDefinition, $def->definition);
			}
		} 
		else 
		{
			while(count($jsonDefinition) < 4 && count($deinitions) >= 1) {
				$definitionKeys = array_keys($definitions);

				//generate random number from 0 to number of definitions.
				$ran = rand(0,count($definitions)-1);

				$defId = $definitionKeys[$ran];
				array_push(	$jsonDefinition, $definitions[$defId]->definition);
				unset($definitions[$defId]);
			}
		}

		//shuffle the array to change the position of the answer
		shuffle($jsonDefinition);
		return $jsonDefinition;
	}
}

